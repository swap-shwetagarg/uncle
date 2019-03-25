<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Services\BookingService;
use App\Services\UserService;
use Auth;
use ConvertIntoArray;
use App\Utility\BookingStatus;
use App\Services\ReferralService;
use Event;
use App\Events\ConfirmedBooking;
use App\Facades\AppSettings;

class PaymentController extends Controller {

    protected $payment;
    protected $booking;
    protected $user;
    protected $referralServices;

    public function __construct(PaymentService $payment, BookingService $booking, UserService $user, ReferralService $referralService) {
        $this->payment = $payment;
        $this->booking = $booking;
        $this->user = $user;
        $this->referralServices = $referralService;
    }

    public function index() {
        $vat_tax = AppSettings::get('vat_tax');
        // Get the currently authenticated user id
        $id = Auth::user()->id;
        $user = $this->user->find($id);
        $result = $user->getBooking()->whereStatus(BookingStatus::PROGRESSING)->orderBy('id', 'desc')->get();        
        return view('web.user.user_payment', ['result' => $result, 'page' => "user-payment", 'vat_tax' => $vat_tax]);
    }

    public function callbackPayment(Request $request) {
        $booking_id = explode('_', $request->cust_ref, 2)[0];
        $is_booked = 0;
        if ($this->booking->find($booking_id)->count() >= 0) {
            if ($request->status == 0) {
                $is_booked = $this->booking->changeBookingStatus($booking_id, ['status' => BookingStatus::PROGRESSING]);
                if ($is_booked) {
                    $redeem_amount = $this->payment->redeemAmount(Auth::user()->id);
                    $all_redeems = $this->referralServices->availableRedeem(Auth::user()->id);
                    foreach ($all_redeems as $redeem) {
                        if ($redeem_amount > 0 && $redeem_amount >= $redeem->amount) {
                            if ($redeem->sender_id == Auth::user()->id)
                                $this->referralServices->update(['sender_booking_id' => $booking_id, 'sender_redeem' => 1], $redeem->id);
                            if ($redeem->rec_id == Auth::user()->id)
                                $this->referralServices->update(['rec_booking_id' => $booking_id, 'rec_redeem' => 1], $redeem->id);
                            $redeem_amount = $redeem_amount - $redeem->amount;
                        } else
                            break;
                    }
                }
            }
            $result = $this->payment->create(['booking_id' => $booking_id, 'transaction_id' => $request->transac_id, 'payment_token' => $request->pay_token, 'mode' => 'Sly-Online', 'status' => $request->status]);
        }
        $bookings = $this->booking->findAll()->where('user_id', '=', Auth::user()->id);
        $data = ['is_booked' => $is_booked, 'payment_status' => $request->status];
        if($is_booked!=0 && $request->status ==0)
            return redirect('/user/thank-you');
        return redirect('/user/bookings')->with('data', $data);
        //return redirect::('web.user.booking.user_bookings',['bookings'=>$bookings,'page'=>'my-bookings','is_booked' => $is_booked, 'payment_status' => $request->status]);   
    }

    function checkPayment($booking_id) {        
        $redeem_amount = $this->payment->redeemAmount(Auth::user()->id);
        $price =$this->booking->find($booking_id)->price;
        if($redeem_amount >0)
            $price =(($this->booking->find($booking_id)->price) - $redeem_amount);
        $url = $this->payment->payment(['booking_id' => $booking_id, 'price' => $price]);
        return response()->json(['payment_url' => $url]);
    }

    public function show($id) {
        
    }

}
