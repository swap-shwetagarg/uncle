<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\OtpAuthentication;
use Auth;
use Validator;
use App\Services\UserService as UserService;
use Laravel\Passport\TokenRepository as Token;
use App\Services\SmsApiService;
use App\Traits\UserReponse;
use App\Traits\ApiUser;
use App\Services\DeviceTokensService as DeviceTokensService;
use App\Utility\BookingStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Services\BookingService;
use App\Facades\AppSettings;
use App\Models\MechanicRoute;
use UpcomingBookings;
use Carbon\Carbon;
use App\Services\ReferralService;
use App\Services\OtpAuthenticationService;

class UserController extends Controller {

    use UserReponse,
        ApiUser;

    protected $user;
    protected $token;
    protected $password;
    protected $smsapi;
    protected $deviceToken;
    protected $booking;
    protected $mechanicRoute;
    protected $refer;
    protected $otpAuthenticationService;

    public function __construct(MechanicRoute $mechanicRoute, BookingService $booking, UserService $user, Token $token, SmsApiService $smsapi, DeviceTokensService $deviceToken, ReferralService $refer, OtpAuthenticationService $otpAuthenticationService) {
        $this->user = $user;
        $this->token = $token;
        $this->smsapi = $smsapi;
        $this->deviceToken = $deviceToken;
        $this->booking = $booking;
        $this->mechanicRoute = $mechanicRoute;
        $this->refer = $refer;
        $this->otpAuthenticationService = $otpAuthenticationService;
    }

    public function index() {
        $result = $this->user->findAll();
        return response()->json(['status' => 'success', 'result' => $result], $this->statusCodeSuccess);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                    'role' => 'required|in:Admin,Mechanic,User',
                    'mobile' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $result = $this->user->create($request->all());

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'User is added Successfully'], $this->statusCodeSuccess);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'User is not added', 'error' => $result], 400);
        }
    }

    public function show($id) {
        try {
            $result = $this->user->find($id);
        } catch (ModelNotFoundException $ex) {
            return $this->getResponse($this->failedStatusTxt, $this->failedMessage, $this->notFoundCode);
        }
        if (count($result)) {
            return response()->json(['status' => $this->successStatusTxt, 'result' => $result], $this->statusCodeSuccess);
        }
    }

    public function update(Request $request, $id) {
        try {
            $result = $this->user->update($request->all(), $id);
        } catch (ModelNotFoundException $ex) {
            return $this->getResponse($this->failedStatusTxt, $this->failedMessage, $this->notFoundCode);
        } catch (QueryException $ex) {
            return $this->getResponse($this->failedStatusTxt, $this->badRequestMsg, $this->badRequest);
        }
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'User is updated Successfully'], $this->statusCodeSuccess);
        }
    }

    public function destroy($id) {
        $result = $this->user->destroy($id);
        if (isset($result) && $result === true) {
            return response()->json(['status' => 'success', 'message' => 'User is deleted Successfully'], $this->statusCodeSuccess);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'User is not deleted', 'error' => $result], 404);
        }
    }

    public function getUserDetails() {
        $user = Auth::user();
        try {
            $bookings = $this->user->find(Auth::id())->bookingMechanic;
        } catch (ModelNotFoundException $ex) {
            return $this->getResponse($this->failedStatusTxt, $this->failedMessage, $this->notFoundCode);
        }
        foreach ($bookings as $booking) {
            $data[] = $booking->booking;
        }
        if (isset($data) && collect($data)->isNotEmpty()) {
            $user->completedBooking = collect($data)->where('status', BookingStatus::COMPLETED)->count();
        } else {
            $user->completedBooking = 0;
        }
        $ratings = User::find(Auth::id())->getRating;
        if ($ratings->isNotEmpty()) {
            $user->overAllRating = $ratings->avg('overall_rating');
        } else {
            $user->overAllRating = 0;
        }
        $address = User::find(Auth::id())->address;
        if ($address->isNotEmpty()) {
            $user->zipcode = $address->pluck('zipcode')->first();
            $user->country = $address->pluck('country')->first();
            $user->area = $address->pluck('area')->first();
            $user->add_1 = $address->pluck('add_1')->first();
            $user->add_2 = $address->pluck('add_2')->first();
        }
        return response()->json(['status' => 'success', 'result' => $user]);
    }

    public function getUserCar() {
        $data = [];
        $user = Auth::user();
        $cars = $user->getCars->where('status', '===', 1);
        if ($cars->isNotEmpty()) {
            $i = 0;
            foreach ($cars as $car) {
                $data [$i]['car_user_id'] = $car->id;
                $data [$i]['car_health'] = $car->car_health;
                $data [$i]['cartrim_id'] = $car->usercars->id;
                $data [$i]['car_trim_name'] = $car->usercars->car_trim_name;
                $data [$i]['car_modal_name'] = $car->usercars->carmodel->modal_name;
                $data [$i]['car_year'] = $car->usercars->carmodel->years->year;
                $data [$i]['car_name'] = $car->usercars->carmodel->years->cars->brand;
                $data [$i]['car_image_url'] = url('/') . '/' . $car->usercars->carmodel->years->cars->image_url;
                $i++;
            }
        }
        return $this->getResponse($this->successStatusTxt, 'Feteched Successfully', $data, 200);
    }

    public function getCounts() {
        $request = new Request();
        $request->status = BookingStatus::QUOTATION;
        $userData['quotesBookingsCount'] = $this->getBookingsByStatus($request)->count();
        $request->status = BookingStatus::APPOINTMENT;
        $userData['appointmentBookingsCount'] = $this->getBookingsByStatus($request)->count();
        $request->status = 0;
        $userData['allBookingsCount'] = $this->getBookingsByStatus($request)->count();
        $userData['myCarCount'] = Auth::user()->getCars->where('status', 1)->count();

        return response()->json(['status' => 'success', 'result' => $userData]);
    }

    public function getUserBookings(Request $request) {
        $data = [];
        $bookings = $this->getBookingsByStatus($request);
        if ($bookings->isNotEmpty()) {
            foreach ($bookings as $booking) {
                $data[] = $this->booking->getSingleBookingDetails($booking);
            }
            return $this->getResponse($this->successStatusTxt, $this->fetched, $data);
        }
        return $this->getResponse($this->successStatusTxt, $this->fetched, $data);
    }

    public function getBookingsByStatus($request) {
        $user = Auth::user();
        if ($request->status == BookingStatus::QUOTATION) {
            $booking_collection = $user->getBooking->whereIn('status', [BookingStatus::QUOTED, BookingStatus::PENDING]);
        } else if ($request->status == BookingStatus::APPOINTMENT) {
            $booking_collection = $user->getBooking->whereIn('status', [BookingStatus::SCHEDULED, BookingStatus::PROGRESSING]);
        } else {
            $booking_collection = $user->getBooking->whereIn('status', BookingStatus::COMPLETED);
        }
        return $this->booking->filteBookingCollection($booking_collection);
    }

    public function getUserBookingsByCarId(Request $request) {
        $this->validate($request, [
            'cartrim_id' => 'required',
        ]);
        $data = [];
        $user = Auth::user();
        $bookings = $user->getBooking->where('cartrim_id', $request->cartrim_id)
                ->where('status', BookingStatus::COMPLETED);
        if ($bookings->isNotEmpty()) {
            foreach ($bookings as $booking) {
                $data[] = $this->booking->getSingleBookingDetails($booking);
            }
            return $this->getResponse($this->successStatusTxt, $this->fetched, $data);
        }
        return $this->getResponse($this->successStatusTxt, $this->fetched, $data);
    }

    public function getPayCredentials() {
        $data['merchant_id'] = AppSettings::get('merchant_id');
        $data['merchant_secret'] = AppSettings::get('api_key');
        return response()->json(['status' => 'success', 'result' => $data]);
    }

    public function getMechanicLocation($booking_id) {
        if ($booking_id) {
            $result = $this->mechanicRoute->whereBookingId($booking_id)->first();
            if (!is_null($result)) {
                return response()->json(['status' => 'success', 'result' => $result], 200);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Not Found'], 404);
    }

    public function getUpcomingBookings() {
        if (UpcomingBookings::getAuthNextBooking()) {
            $data = UpcomingBookings::getAuthNextBooking();
            $bookings = [];
            $i = 0;
            foreach ($data['booking'] as $booking) {
                $bookings[$i]['next_date'] = $booking[0];
                $bookings[$i]['next-date'] = $booking[0];
                $bookings[$i]['brand'] = $booking[1]->carTrim->carmodel->years->cars->brand;
                $bookings[$i]['year'] = $booking[1]->carTrim->carmodel->years->year;
                $bookings[$i]['model_name'] = $booking[1]->carTrim->carmodel->modal_name;
                $bookings[$i]['trim_name'] = $booking[1]->carTrim->car_trim_name;
                $bookings[$i]['mechanic_name'] = $booking[1]->bookingMechanic->mechanic->name;
                $bookings[$i]['booked_date'] = $booking[1]->date_time = Carbon::parse($booking[1]->date_time)->format('d-m-Y');
                $i++;
            }
            return response()->json(['status' => 'success', 'result' => $bookings]);
        }
        return response()->json(['status' => 'success', 'result' => []]);
    }

    public function getUserSettings() {
        $name = Auth::user()->name;
        $url = $this->refer->getBase64Url(Auth::user()->id, Auth::user()->email);
        $referral_link = url('/register?' . $url);
        $referral_settings = $this->refer->getReferralSettings();
        if (isset($referral_settings) && $referral_settings && isset($referral_settings['referral_share_text']) && $referral_settings['referral_share_text']) {
            $referral_share_content = $referral_settings['referral_share_text'];
            $referral_share_content = str_replace("{USER_NAME}", $name, $referral_share_content);
            $referral_share_content = str_replace("{REFERRAL_SHARE_LINK}", $referral_link, $referral_share_content);
            $referral_settings['referral_share_text'] = $referral_share_content;
            $referral_settings['referral_link'] = $referral_link;
        }
        $userData['referral_settings'] = $referral_settings;
        return response()->json(['status' => 'success', 'result' => $userData]);
    }

}
