<?php

namespace App\Http\Controllers\Web;

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
        $ratings = join(',', array((is_null($request['rating1']) ? '0' : $request['rating1']), (is_null($request['rating2']) ? '0' : $request['rating2']), (is_null($request['rating3']) ? '0' : $request['rating3'] ), (is_null($request['rating4']) ? '0' : $request['rating4']), (is_null($request['rating5']) ? '0' : $request['rating5'])));
        $booking_id = $request['booking_id'];
        $mechanic_id = $request['mechanic_id'];
        $total_rating = (is_null($request['rating6']) ? '' : $request['rating6']);
        $booking = $this->bookingService->find($booking_id);
        if ($booking->user_id == Auth::user()->id && $booking->bookingMechanic->mechanic->id == $mechanic_id) {
            $result = $this->rate->create(['ratings' => $ratings,'overall_rating' => $total_rating, 'booking_id' => $booking_id, 'mechanic_id' => $mechanic_id, 'user_id' => Auth::id()]);
            $data = ['is_rated' => $result];
            return redirect('/user/bookings')->with('rated', $data);
        } else
            return redirect('/user/bookings');
    }

}
