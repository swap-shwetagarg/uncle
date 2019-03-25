<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentService as PaymentService;
use App\Services\BookingService as BookingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Facades\AppSettings;

class PaymentController extends Controller {

    protected $payment;
    protected $booking;

    public function __construct(PaymentService $payment, BookingService $booking) {
        $this->payment = $payment;
        $this->booking = $booking;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $vat_tax = AppSettings::get('vat_tax');
        $result = $this->payment->findAll();
        return view('admin.payment', ['result' => $result, 'page' => 'payment', 'vat_tax' => $vat_tax]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        try {
            $paymentResult = $this->payment->payment($request->all());
        } catch (QueryException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->duplicate], $this->badRequest);
        }
        if ($paymentResult) {
            return response()->json(['status' => 'success', 'message' => $paymentResult], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $result['booking'] = $this->booking->getBooking($id);
        $result['car_trim'] = $result['booking']->carTrim;
        $result['car_model'] = $result['car_trim']->carmodel;
        $result['car'] = $result['car_model']->years->cars;
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', $result], 200);
        } else {
            return response()->json(['status' => 'failed', $result], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        try {
            $result = $this->payment->update($request->all(), $id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->failedMessage], $this->notFoundCode);
        } catch (QueryException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->duplicate], $this->badRequest);
        }
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Payment is updated Successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        try {
            $result = $this->payment->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->failedMessage], $this->notFoundCode);
        } catch (\Exception $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->cantDelete], $this->badRequest);
        }
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Payment is deleted Successfully'], 200);
        }
    }

    public function callbackPayment(Request $request) {
        if (isset($request->transac_id)) {
            $data = [
                'transaction_id' => $request->transac_id,
                'booking_id' => $request->cust_ref,
                'mode' => 'Online',
                'status' => $request->status,
                'payment_token' => $request->pay_token
            ];
        }

        $result = $this->payment->create($data);

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Payment is done'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Payment is not success'], 404);
        }
    }

}
