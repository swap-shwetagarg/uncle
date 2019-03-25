<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentService as PaymentService;
use ConvertIntoArray;
use App\Services\BookingService;
use App\Utility\BookingStatus;
use App\Services\ReferralService;
use Auth;
use App\Services\ExpressPayService;
use Event;
use App\Events\PaymentAlert;

class PaymentController extends Controller {

    protected $payment;
    protected $booking;
    protected $referralServices;
    protected $expPayService;
    private $isDone = 'Payment is successfully done';
    private $isFailed = 'Payment is failed';

    public function __construct(ExpressPayService $expPayservice,ReferralService $referralServices,BookingService $booking,PaymentService $payment) {
        $this->payment = $payment;
        $this->booking = $booking;
        $this->referralServices = $referralServices;
        $this->expPayService = $expPayservice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $result = $this->payment->findAll();

        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $paymentResult = $this->payment->payment($request->all());
        if ($paymentResult) {
            return response()->json(['status' => 'success', 'message' => $paymentResult], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => ''], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $result = $this->payment->find($id);
        
        if (count($result)>0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => $result], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $result = $this->payment->update($request->all(), $id);

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Payment is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Payment is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $result = $this->payment->destroy($id);

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Payment is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Payment is not deleted', 'error' => $result], 404);
        }
    } 
    
    public function checkForPayment($id,Request $request) {
        $booking = $this->booking->find($id);
        $booking->redirecturl = $request->redirect;
        $redeem_amount = $this->payment->redeemAmount($booking->getUser->id);
        $amount = ($booking->price- $redeem_amount);
        $result = $this->expPayService->GetToken($booking, $amount,0);
        if($this->expPayService->isSendBox){
            $base_url = 'https://sandbox.expresspaygh.com/api/checkout.php';
        }else{
            $base_url = 'https://expresspaygh.com/api/checkout.php';
        }
        if($result!= '' ){
            $url = $base_url.'?token='.json_decode($result)->token;
            return redirect()->away($url);
        }else{
            return back();
        }
    }
    
    public function expCallbackPayment(Request $request) {
        $server_responce = $this->expPayService->GetResponse($request);
        $booking_id = $server_responce->{'order-id'};
        $booking = $this->booking->find($booking_id);
        if (!is_null($booking)) {
            if ($server_responce->result === 1) {
                $is_booked = $this->booking->changeBookingStatus($booking_id, ['status' => BookingStatus::PROGRESSING]);
                if ($is_booked) {
                    $avialableredeem_amount = $this->payment->redeemAmount($booking->getUser->id);
                    $redeem_amount = $booking->price;
                    if($avialableredeem_amount >= $redeem_amount){
                        $all_redeems = $this->referralServices->availableRedeem($booking->getUser->id);
                        foreach ($all_redeems as $redeem) {
                            if ($redeem_amount > 0 && $redeem_amount >= $redeem->amount) {
                                if ($redeem->sender_id === $booking->getUser->id)
                                    $this->referralServices->update(['sender_booking_id' => $booking_id, 'sender_redeem' => 1], $redeem->id);
                                if ($redeem->rec_id === $booking->getUser->id)
                                    $this->referralServices->update(['rec_booking_id' => $booking_id, 'rec_redeem' => 1], $redeem->id);
                                $redeem_amount = $redeem_amount - $redeem->amount;
                            } else
                                break;
                        }
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
                Event::fire(new PaymentAlert($booking->getUser,$this->isDone));
                $url = $request->redirect.'?payment_status=success';
                return redirect()->away($url);
            }
        }
        Event::fire(new PaymentAlert($booking->getUser,$this->isFailed));
        $url = $request->redirect.'?payment_status=cancel';
        return redirect()->away($url);
    }
    
    public function getPaymentInfo($bookingId) {
        try{
            $booking = $this->booking->find($bookingId);
        } catch (\Exception $ex){
            $message = ['message' => 'There is no booking for this booking Id'];
            return response()->json(['status' => 'failed','error' => $message]);
        }
        $payments = $booking->payment;
        if($payments->isNotEmpty()){
            return response()->json(['status' => 'success' ,'result' => $payments]);
        }
        return response()->json(['status' => 'success' ,'result' => null]);
    }
    
    public function getAllUserBillings() {
        $payments = null;
        $user = Auth::user();
        $bookings = $user->getBooking;
        if($bookings->isNotEmpty()){
            foreach ($bookings as $booking){                
                if($booking->payment->isNotEmpty()){
                    $payment = $booking->payment->first();
                    $payment->amount = $booking->price;
                    $payment->reddem_amount = $this->payment->redeemAmountForBooking($booking->id);
                    $payments[] = $payment;
                }
            }
        }
        return response()->json(['status' => 'success' ,'result' => $payments]);
    }
    
    public function byReedemAmount($id) {
        $booking = $this->booking->find($id);
        if($booking){        
            $is_booked = $this->booking->changeBookingStatus($booking->id, ['status' => BookingStatus::PROGRESSING]);
            if ($is_booked) {
                $avialableredeem_amount = $this->payment->redeemAmount($booking->getUser->id);
                $redeem_amount = $booking->price;
                if($avialableredeem_amount >= $redeem_amount){
                    $all_redeems = $this->referralServices->availableRedeem($booking->getUser->id);
                    foreach ($all_redeems as $redeem) {
                        if ($redeem_amount > 0 && $redeem_amount >= $redeem->amount) {
                            if ($redeem->sender_id === $booking->getUser->id)
                                $this->referralServices->update(['sender_booking_id' => $booking_id, 'sender_redeem' => 1], $redeem->id);
                            if ($redeem->rec_id === $booking->getUser->id)
                                $this->referralServices->update(['rec_booking_id' => $booking_id, 'rec_redeem' => 1], $redeem->id);
                            $redeem_amount = $redeem_amount - $redeem->amount;
                        } else
                            break;
                    }
                }     
            }
            $is_done = $this->payment->findBookingPayment($booking->id);
            if($is_done){
                $is_done->status = 6;
                $is_done->save();
            }else{
                $result = $this->payment->create([
                    'booking_id' => $booking->id,
                    'transaction_id' => 'UF-BY-REEDEM-'.rand(1000000,1000000000),
                    'mode' => 'by-reedem', 
                    'status' => 6
                ]);
            }
            Event::fire(new PaymentAlert($booking->getUser,$this->isDone));
            return response()->json(['status' => 'success','message' => 'Payment done successfully.']);
        }
        return response()->json(['status' => 'error','message' => 'Payment not Done.'],400);
    }
}
