<?php

namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Repositories\Payment\PaymentInterface as PaymentInterface;
use Illuminate\Support\Facades\Log;
use Slydepay\Order\Order;
use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;
use Auth;
use Carbon\Carbon;
use AppSettings;
use DB;
use Illuminate\Support\Facades\App;

class PaymentRepository implements PaymentInterface {

    protected $payment;
    protected $slydeKey = null;
    protected $slydeEmail = null;

    public function __construct(Payment $payment) {
        $this->payment = $payment;
        $this->slydeKey = env('SLYDEPAY_KEY');
        $this->slydeEmail = env('SLYDEPAY_EMAIL');
    }

    /**
     * Get all instance of BookingItems.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\BookingItems[]
     */
    public function findAll() {
        return $this->payment->orderBy('id', 'desc')->paginate(15);
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->payment->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->payment->insert($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    /**
     * Update the BookingItems with the given attributes.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function update(array $attributes = [], $id) {
        try {
            return $this->payment->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    /**
     * Delete an entry with the given ID.
     *
     * @param  int  $id
     * @return bool|null
     * @throws \Exception
     */
    public function destroy($id) {
        try {
            return $this->payment->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function payment(array $data) {
        if (App::environment('local')) {
            AppSettings::set('slyde_email', 'unclefitter@encoresky.com');
        } elseif (App::environment('development')) {
            AppSettings::set('slyde_email', 'unclefitter@encoresky.com');
        } elseif (App::environment('production')) {
            AppSettings::set('slyde_email', 'accts@unclefitter.com');
        }
        AppSettings::set('slyde_email', 'accts@unclefitter.com');
        AppSettings::set('slyde_key', '1496405855990');
        $slydepay = new \Slydepay\Slydepay(AppSettings::get('slyde_email'), AppSettings::get('slyde_key'));

        $orderItems = new OrderItems([
            new OrderItem($data['booking_id'], "Uncle-Fitter-Service", $data['price'], 1, $data['price']),
        ]);

        $shippingCost = 0;
        $taxAmount = 0;
        $description = "This is payment For Uncle-Fitter-Car-Service";
        $userId = Auth::user()->id;
        $order = Order::createWithId($orderItems, $data['booking_id'] . '_' . $userId . '_' . Carbon::now(), $shippingCost, $taxAmount, $description);

        try {
            $response = $slydepay->processPaymentOrder($order);
            return $response->redirectUrl();
        } catch (Slydepay\Exception\ProcessPayment $e) {
            echo $e->getMessage();
        }
    }

    public function redeemAmount($id) {
        $amount = DB::select('Select sum(amount) as redeem_amount from((SELECT 1 as id,sum(amount) as amount
                                FROM referral 
                                WHERE (rec_id = ? and  rec_redeem =0) 
                                    Group by rec_id  DESC) 
                UNION ALL
                            (SELECT 1 as id,sum(amount) as amount
                                FROM referral 
                                WHERE (sender_id = ? And  rec_redeem =1 And sender_redeem = 0) 
                                    Group by sender_id DESC)
                        )temp group by id'
                        , array($id, $id));

        return count($amount) > 0 ? $amount[0]->redeem_amount : 0;
    }

    public function redeemAmountForBooking($booking_id) {
        $amount = DB::select('Select sum(amount) as redeem_amount FROM
                                (SELECT sum(amount) as amount
                                    FROM referral 
                                    WHERE rec_booking_id = ? OR sender_booking_id = ?
                                    Group by rec_booking_id,sender_booking_id  DESC
                                ) refTemp'
                        , array($booking_id, $booking_id));
        return $amount[0]->redeem_amount ? $amount[0]->redeem_amount : 0;
    }

    public function findBookingPayment($id) {
        $isdone = $this->payment->whereBooking_id($id)->first();
        if (is_null($isdone)) {
            return false;
        }
        return $isdone;
    }

}
