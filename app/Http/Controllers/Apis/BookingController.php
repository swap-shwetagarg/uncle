<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookingService as BookingService;
use Auth;
use App\Http\Requests\BookingFormRequest;
use Event;
use App\Events\SendQuotedMail;
use App\Events\BookingCancelled;
use App\Utility\BookingStatus;
use App\Services\CarServiceService;
use App\Services\PaymentService;
use DateTime;
use App\Services\AddressService;
use App\Services\BookingMechanicService;
use App\Facades\AppSettings;

class BookingController extends Controller {

    protected $bookingService;
    protected $service;
    private $paymentService;
    private $useraddress;
    private $bookingMechanicService;

    public function __construct(BookingMechanicService $bookingMechanicService, AddressService $useraddress, PaymentService $paymentService, BookingService $bookingService, CarServiceService $service) {
        $this->bookingService = $bookingService;
        $this->service = $service;
        $this->paymentService = $paymentService;
        $this->useraddress = $useraddress;
        $this->bookingMechanicService = $bookingMechanicService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $result = $this->bookingService->findAll(1);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => 'No Bookings found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'cartrim_id' => 'required',
        ]);
        $tempData = $request->all();
        if (isset($tempData) && count($tempData) > 1) {
            $data = $tempData;
        } else {
            $error = ['message' => 'we required service or own_service_description field'];
            return response()->json(['status' => 'failed', 'error' => $error], 422);
        }
        try {
            $result = $this->bookingService->booking($data);
        } catch (\Exception $ex) {
            $error = ['message' => 'Booking is not completed...Try again'];
            return response()->json(['status' => 'failed', 'error' => $error], 400);
        }

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Booking is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Booking is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $result = $this->bookingService->getBooking($id);
        if (count($result) > 0 && $result != []) {
            $price = $result['booking']['price'];
            $vat_percentage = 0;
            if ($price && $price != '0.00') {
                $vat_cost = $result['booking']['vat_cost'];
                $vat_percentage = ($vat_cost * 100) / $price;
            }
            $result['booking']['vat_percentage'] = $vat_percentage;
            $result['booking']['total_price'] = number_format(($result['booking']['parts_cost'] + $result['booking']['labour_cost'] + $result['booking']['vat_cost']), 2);
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => []], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookingFormRequest $request, $id) {
        $result = $this->bookingService->update(['price' => $request->price], $id);

        if ($result === true) {
            $this->changeToQuoted($id);
            return response()->json(['status' => 'success', 'message' => 'Booking is quoted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Booking is not quoted', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $booking_message = '';
        $result = true;
        try {
            $booking = $this->bookingService->find($id);
            if (!is_null($booking)) {
                if ($booking->status === BookingStatus::PENDING) {
                    $result = $this->bookingService->destroy($id);   //Permanent Delete Booking
                    $booking_message = 'Booking is deleted Successfully';
                } else if ($booking->status == BookingStatus::QUOTED) {
                    $result = $this->bookingService->update(['status' => 5], $id); //Soft Delete Booking
                    $booking_message = 'Booking is deleted Successfully';
                } else if ($booking->status === BookingStatus::PROGRESSING || $booking->status === BookingStatus::SCHEDULED) {
                    $result = $this->bookingService->update(['status' => 9], $id);  //Cancelled Booking
                    $booking_message = 'Booking is cancelled Successfully';
                    Event::fire(new BookingCancelled($id, $booking));
                } else if ($booking->status === BookingStatus::DELETED) {
                    $booking_message = 'Booking is already deleted .';
                } else if ($booking->status === BookingStatus::CANCELLED) {
                    $booking_message = 'Booking is already cancelled .';
                } else {
                    $booking_message = 'Booking is already completed You can not delete/cancel this booking .';
                }
            }
        } catch (\Exception $ex) {
            $result = false;
        }
        if ($result) {
            return response()->json(['status' => 'success', 'message' => $booking_message], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Booking is not found.'], 404);
        }
    }

    public function getUserProcessing($id) {
        $result = $this->changeToProcessing($id);
        if ($result) {
            return response()->json(['status', 'Success']);
        }
        return response()->json(['status', 'Failed']);
    }

    protected function changeToPending($id) {
        return $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::PENDING]);
    }

    protected function changeToQuoted($id) {
        $result = $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::QUOTED]);
        $event['details'] = $this->bookingService->getBooking($id);
        Event::fire(new SendQuotedMail($event));
        if ($result) {
            return true;
        }
        return false;
    }

    protected function changeToConfirm($id) {
        return $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::CONFIRMED]);
    }

    protected function changeToProcessing($id) {
        return $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::PROGRESSING]);
    }

    protected function changeToSheduled($id) {
        return $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::SCHEDULED]);
    }

    protected function changeToCompleted($id) {
        return $this->bookingService->changeBookingStatus($id, ['status' => BookingStatus::COMPLETED]);
    }

    public function scheduleBooking($id) {
        $vat_tax = AppSettings::get('vat_tax');
        $booking = Auth::user()->getBooking->where('id', $id)->first();
        if (is_null($booking)) {
            $error = ['message' => 'Unable to find booking for current user'];
            return response()->json(['status' => 'failed', 'error' => $error], 404);
        }
        $dt = new DateTime('tomorrow');
        $redeem_amount = 0;
        $redeem_amount = $this->paymentService->redeemAmount(Auth::user()->id);
        if ($booking->status === BookingStatus::QUOTED || $booking->status === BookingStatus::PROGRESSING) {
            $booking_price = $booking->price;
            $vat_cost = $booking->vat_cost;
            /*
              $vat_price = ($booking_price * $vat_tax) / 100;
              $total_price = $booking_price + $vat_price;
             */
            $vat_percentage = ($vat_cost * 100) / $booking_price;
            $data['booking_price'] = number_format($booking_price, 2);
            $data['vat_percentage'] = number_format($vat_percentage, 2);
            $data['total_vat'] = number_format($vat_cost, 2);

            $total_price = $booking_price + $vat_cost;
            $data['price'] = number_format($total_price, 2);
            $data['redeem_amount'] = number_format($redeem_amount, 2);
            $data['total_payable_price'] = number_format($total_price - $redeem_amount, 2);
            $data['booking_schdule_date_from'] = $dt->format('Y-m-d H:i:s');

            $data['payment_gateway'] = 1;
            if ($redeem_amount >= $total_price) {
                $data['payment_gateway'] = 0;
            }

            return response()->json(['status' => 'success', 'result' => $data]);
        } else {
            $error = ['message' => 'Requested booking may be pending or schduled'];
            return response()->json(['status' => 'failed', 'error' => $error]);
        }
    }

    public function availableTimes(Request $request) {
        $available_times = $this->bookingMechanicService->getAvailableTimes($request->date);
        if ((date("Y-m-d", strtotime(str_replace('/', '-', $request->date))) < date("Y-m-d"))) {
            $available_times = $this->bookingMechanicService->getDefaultTimes();
        } elseif ((date("Y-m-d", strtotime(str_replace('/', '-', $request->date))) == date("Y-m-d"))) {
            $arr = array('7' => 'A', '9' => 'B', '11' => 'C', '13' => 'D', '15' => 'E', '17' => 'F');
            for ($i = 7; $i <= 17; $i += 2) {
                if ((date("H") >= $i)) {
                    $available_times[0]->{$arr[$i]} = 0;
                }
            }
        }
        $booking = $this->bookingService->find($request->booking_id);
        $data['available_times'] = $available_times;
        $data['address'] = $booking->address;
        $data['location'] = $booking->getZipCode->zip_code . ' ' . $booking->getZipCode->country_code;
        return response()->json(['status' => 'success', 'result' => $data]);
    }

}
