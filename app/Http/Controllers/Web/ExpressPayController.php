<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\UserService;
use App\Services\ReferralService;
use App\Services\PaymentService;
use App\Utility\BookingStatus;
use Illuminate\Support\Facades\Auth;
use App\Services\ExpressPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ExpressPayController extends Controller {

    protected $payment;
    private $bookingService;
    protected $user;
    protected $referralServices;
    protected $expPayService;

    public function __construct(PaymentService $payment, BookingService $bookingService, UserService $user, ReferralService $referralService, ExpressPayService $expPayservice) {
        $this->payment = $payment;
        $this->bookingService = $bookingService;
        $this->user = $user;
        $this->referralServices = $referralService;
        $this->expPayService = $expPayservice;
    }

    public function checkForPayment($id) {
        $booking = $this->bookingService->find($id);
        $redeem_amount = $this->payment->redeemAmount(Auth::user()->id);
        $amount = ($booking->price- $redeem_amount);
        $result = $this->expPayService->GetToken($booking, $amount);
        if($result!= '' )
            return response()->json(['result' => \GuzzleHttp\json_decode($result), 'url' => ($this->expPayService->isSendBox ? 'https://sandbox.expresspaygh.com/api/checkout.php' : 'https://expresspaygh.com/api/checkout.php')]);
        else
            return response()->json(['status' => 'Failed', 'message' => 'Invalid payment service.']);                
    }

    public function expCallbackPayment(Request $request) {
        $server_responce = $this->expPayService->GetResponse($request);
        $booking_id = $server_responce->{'order-id'};

        if ($this->bookingService->find($booking_id)->count() >= 0) {
            if ($server_responce->result == 1) {
                $is_booked = $this->bookingService->changeBookingStatus($booking_id, ['status' => BookingStatus::PROGRESSING]);
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
                $payment = $this->payment->findBookingPayment($request->bookingId);
                if($payment && $payment->status === 4){
                    $result = $this->payment->update([
                            'booking_id' => $booking_id,
                            'transaction_id' => $server_responce->{'transaction-id'},
                            'payment_token' => $server_responce->token,
                            'mode' => 'ExpressPay', 
                            'status' => 6
                    ],$payment->id);
                }
            }
            else
            {
                $data = ['is_booked' => 0, 'payment_status' => ($server_responce->result == 4 ? 4 : 0)];
               return redirect('/user/bookings')->with('data', $data); 
            }
        }
        $bookings = $this->bookingService->findAll()->where('user_id', '=', Auth::user()->id);
        if ($is_booked != 0 && ($server_responce->result == 1) )
            return redirect('/user/thank-you');
    }

}
