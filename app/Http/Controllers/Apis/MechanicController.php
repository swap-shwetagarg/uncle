<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Services\BookingService as Booking;
use App\Models\BookingMechanic as Book_mech;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Event;
use App\Events\MechanicConfirmation;
use App\Events\MechanicLocation;
use App\Events\BookingComplete;
use App\Events\BookingCompletionToUser;
use App\Utility\BookingStatus;
use AppSettings;
use App\Services\UserCarService as UserCarService;
use App\Helpers\CalculateTime;
use Carbon\Carbon;
use App\Models\Booking as Book;
use App\Services\PaymentService;
use ConvertIntoArray;
use App\Models\MechanicRoute;

class MechanicController extends Controller {

    protected $booking;
    protected $usercar;
    protected $payment;
    protected $mechanicRoute;

    public function __construct(MechanicRoute $mechanicRoute, Booking $booking, UserCarService $usercar, PaymentService $payment) {
        $this->booking = $booking;
        $this->usercar = $usercar;
        $this->payment = $payment;
        $this->mechanicRoute = $mechanicRoute;
    }

    public function index() {
        $bookinglistDetails = [];
        try {
            $mechanicBooking = Auth::user()->bookingMechanic;
            if (count($mechanicBooking)) {
                foreach ($mechanicBooking as $key) {
                    $bookinglistDetail = $this->booking->getBookinglistDetails($key);
                    if ($bookinglistDetail) {
                        if($this->booking->checkCarStatusByBooking($bookinglistDetail['booking_id'])){
                            $bookinglistDetails[] = $bookinglistDetail;
                        }
                    }
                }
            }
            return $this->successResponse($bookinglistDetails);
        } catch (\Exception $ex) {
            return $this->failedResponse();
        }
    }

    public function getBookingByDate(Request $request) {
        $date = [];
        $tempData = array();
        try {
            $mechanicBooking = Auth::user()->bookingMechanic->where('mech_response', '!=', 0);
            if ($mechanicBooking->isNotEmpty()) {
                $date = CalculateTime::getLastFirst($request);
                foreach ($mechanicBooking as $key) {
                    $bookinglistDetail = $this->booking->getBookinglistDetails($key);
                    if ($bookinglistDetail) {
                        $data[] = $bookinglistDetail;
                    }
                }
                $datas = collect($data);

                $first_date = Carbon::createFromFormat('Y-m-d H:i:s', $date['firstDate'])->format('Y-m-d');
                $last_date = Carbon::createFromFormat('Y-m-d H:i:s', $date['lastDate'])->format('Y-m-d');

                $dates = $datas->where('booking_date_time', '>=', $first_date)
                        ->where('booking_date_time', '<=', $last_date)
                        ->sortByDesc('status')
                        ->sortBy('booking_date_time')
                        ->pluck('booking_date_time')
                        ->unique();
                if ($dates && sizeof($dates)) {
                    foreach ($dates as $d) {
                        $tempData[] = Carbon::createFromFormat('Y-m-d', $d)->format('d-m-Y');
                    }
                }
            }
            return $this->successResponse($tempData);
        } catch (\Exception $ex) {
            return $this->failedResponse();
        }
    }

    public function getBookingIntoDate(Request $request) {
        try {
            $data = [];
            $tempArray = [];
            $date = new Carbon($request->date);
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
            $bookings = \DB::table('bookings')->whereDate('schedule_date', $date)->get();
            if ($bookings) {
                foreach ($bookings as $booking) {
                    $data[] = $booking->id;
                }
            }
            $mechBookIds = Auth::user()->bookingMechanic;
            if ($mechBookIds->isNotEmpty()) {
                foreach ($mechBookIds as $mechBookId) {
                    if ($data && sizeof($data) && in_array($mechBookId->booking_id, $data)) {
                        $tempArray[] = $this->booking->getBookinglistDetails($mechBookId);
                    }
                }
            }
            return $this->successResponse($tempArray);
        } catch (\Exception $ex) {
            return $this->failedResponse();
        }
    }

    public function show($id) {
        $booking = $this->booking->getBooking($id);
        if ($booking) {
            $price = $booking['booking']['price'];
            $vat_percentage = 0;
            if ($price && $price != '0.00') {
                $vat_cost = $booking['booking']['vat_cost'];
                $vat_percentage = ($vat_cost * 100) / $price;
            }
            $booking['booking']['vat_percentage'] = $vat_percentage;
            $booking['booking']['total_price'] = number_format(($booking['booking']['parts_cost'] + $booking['booking']['labour_cost'] + $booking['booking']['vat_cost']), 2);

            return $this->successResponse($booking);
        }
        return $this->failedResponse();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'mech_response' => 'required|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'error' => $validator->errors()], 422);
        }
        try {
            $result = Book_mech::findOrFail($id);
        } catch (\Exception $ex) {
            return $this->failedResponse(null, 404);
        }
        $booking = $result->booking;
            if ($request->mech_response && $request->mech_response == 1) {
                $booking->status = BookingStatus::SCHEDULED;
            } elseif ($request->mech_response == 0) {
                $booking->status = BookingStatus::PROGRESSING;
            }
            $result->mech_response = $request->mech_response;
            if ($booking->save() && $result->save()) {
                Event::fire(new MechanicConfirmation());
                return $this->successResponse(trans('customResponse.mechResponse'));
            }
    }

    public function confirmBookingCompletionStatus(Request $request) {
        $this->validate($request, [
            'bookingId' => 'required',
        ]);
        $result = $this->booking->changeBookingStatus($request->bookingId, ['status' => BookingStatus::COMPLETED]);
        if ($result) {
            $this->doPayment($request);
            Event::fire(new BookingComplete());
            Event::fire(new BookingCompletionToUser($this->booking->find($request->bookingId)));
            return $this->successResponse(trans('customResponse.completeBookingSuccessResponse'));
        }
        return $this->failedResponse(trans('customResponse.completeBookingFailedResponse'));
    }

    public function getCarHealth($id) {
        $carHealth = $this->getUserCar($id);
        if (isset($carHealth->car_health) && $carHealth->car_health && $carHealth->car_health != '' && $carHealth->car_health != null) {
            $jsonArr = json_decode($carHealth->car_health, true);
            if ($jsonArr['bookingId'] == $id) {
                $result['userCarHealth'] = json_decode(json_encode($jsonArr), true);
            } else {
                $car_health_parameters = AppSettings::get('car_health_parameters');
                $jsonArr = json_decode($car_health_parameters);
                $result['userCarHealth'] = json_decode(json_encode($jsonArr), true);
            }
        } else {
            $car_health_parameters = AppSettings::get('car_health_parameters');
            $jsonArr = json_decode($car_health_parameters);
            $result['userCarHealth'] = json_decode(json_encode($jsonArr), true);
        }
        return $this->successResponse($result);
    }

    /**
     *  This function will update user car health on the basis of user car id. 
     *  This will accept two mandatory parameter -- input data ($request) and id (user car id). 
     */
    public function updateCarHealth(Request $request) {
        try {
            $carHealth = $this->getUserCar($request->bookingId);
            $array = ['bookingId' => $request->bookingId, 'car_health_report' => $request->car_health];
            $result = $this->usercar->update($array, $carHealth->id);
            if ($result) {
                return $this->successResponse(trans('customResponse.successUpdateCarHealth'));
            } else {
                return $this->failedResponse(trans('customResponse.failedUpdateCarHealth'));
            }
        } catch (\Exception $ex) {
            return $this->failedResponse(trans('customResponse.failedUpdateCarHealth'));
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error($ex);
        }
    }

    public function submitMechanicLocation(Request $request) {
        $this->validate($request, [
            'booking_id' => 'required',
        ]);
        $route = $this->mechanicRoute->whereBookingId($request->booking_id)->first();
        try {
            $booking = $this->booking->getBooking($request->booking_id);
            if ($booking) {                
                if (is_null($route)) {
                    $array = [
                        'booking_id' => $request->booking_id,
                        'mech_location' => $request->mech_location,
                        'mech_starting_location' => $request->mech_location,
                        'user_location' => $booking['booking']['address'],
                        'isReached' => $request->isReached
                    ];
                    $result = $this->mechanicRoute->create($array);
                    $bookedMech = Book_mech::whereBooking_idAndMechanic_id($request->booking_id,Auth::id())->first();
                    if(!is_null($bookedMech)){
                        $bookedMech->mech_response = 1 ;
                        if($bookedMech->save()){
                            $book = Book::find($booking['booking']['id']);
                            Event::fire(new MechanicLocation($book));
                        }
                    }
                } else {
                    $result = $this->mechanicRoute->findOrFail($route->id)->update($request->except('mech_starting_location', 'booking_id','user_location'));
                }
            } else {
                return $this->failedResponse('Request is invalid', 400);
            }
        } catch (\Exception $ex) {
            return $this->failedResponse('Request is invalid', 400);
        }
        if ($result) {
            if ($result === true) {
                $result = $this->mechanicRoute->whereBookingId($request->booking_id)->first();
            }
            return $this->successResponse($result);
        }
        return $this->failedResponse(null, 404);
    }

    protected function getUserCar($id) {
        $bookingDetail = $this->booking->find($id);
        return $this->usercar->getUserCarDetails($bookingDetail->toArray());
    }

    protected function doPayment(Request $request) {
        $isdone = $this->payment->findBookingPayment($request->bookingId);
        $data = ConvertIntoArray::makePayment($request->bookingId);
        if ($isdone && $isdone->status === 4) {
            $this->payment->update($data, $isdone->id);
        }
    }

    protected function failedResponse($status = null, $responseStatus = null) {
        return response()->json(['status' => 'failed', 'message' => isset($status) ? $status : 'Not Found'], isset($responseStatus) ? $responseStatus : '500');
    }

    protected function successResponse($data = null) {
        return response()->json(['status' => 'success', 'result' => isset($data) ? $data : 'Successfully Done'], 200);
    }

}
