<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Event;
use App\Services\RatingService;
use App\Services\BookingService;

class RatingController extends Controller {

    protected $bookingService;
    protected $rate;

    public function __construct(BookingService $bookingService, RatingService $rate) {
        $this->bookingService = $bookingService;
        $this->rate = $rate;
    }

    public function getMechanicRating($mechanic_id, $booking_id) {
        $booking = $this->bookingService->find($booking_id);
        if ($booking->user_id == Auth::user()->id && $booking->bookingMechanic->mechanic->id == $mechanic_id) {
            $rating = $this->rate->getSavedRating($booking_id,$mechanic_id, Auth::id());
            return view('web.user.rate.rate_mechanic', ['booking_id' => $booking_id, 'mechanic_id' => $mechanic_id, 'rating'=>$rating]);
        } else
            return redirect('/user/bookings');
    }

    public function saveMechanicRating(Request $request) {
        $ratings = join(',', array((is_null($request['rating1']) ? '0' : $request['rating1']), (is_null($request['rating2']) ? '0' : $request['rating2']), (is_null($request['rating3']) ? '0' : $request['rating3'] ), (is_null($request['rating4']) ? '0' : $request['rating4'])));
        $booking_id = $request['booking_id'];
        $mechanic_id = $request['mechanic_id'];
        //$total_rating = (is_null($request['rating6']) ? '' : $request['rating6']);
        $total_rating = (is_null($request['rating5']) ? '' : $request['rating5']);
        $user_note = (is_null($request['user_note']) ? '' : $request['user_note']);
        try {
            $booking = $this->bookingService->find($booking_id);
        } catch (\Exception $ex) {
            $error = ['message' => 'Unable to find booking'];
            return response()->json(['status' => 'failed' , 'error' => $error],$this->notFoundCode);
        }
        if ($booking->user_id == Auth::user()->id && $booking->bookingMechanic->mechanic->id == $mechanic_id) {
            try {
                $result = $this->rate->create(['user_note' => $user_note,'ratings' => $ratings,'overall_rating' => $total_rating, 'booking_id' => $booking_id, 'mechanic_id' => $mechanic_id, 'user_id' => Auth::id()]);
            } catch (\Exception $ex) {
                $error = ['message' => 'Failed to submit Mechanic rating'];
                return response()->json(['status' => 'failed' , 'error' => $error],$this->badRequest);
            }
            $data = ['is_rated' => $result];
            return response()->json(['status' => 'success','message' => 'Mechanic Successfully Rated']);
        } else{
            $error = ['message' => 'Unable to find user and Mechanic'];
            return response()->json(['status' => 'failed' , 'error' => $error],$this->notFoundCode);
        }
    }

}
