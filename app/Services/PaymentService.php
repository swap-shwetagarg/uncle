<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 11:12 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Payment\PaymentInterface as PaymentInterface;


class PaymentService extends BaseService {
    protected $paymentInterface;

    public function __construct(PaymentInterface $paymentInterface) {
        $this->paymentInterface = $paymentInterface;
    }

    public function findAll() {
        return $this->paymentInterface->findAll();
    }

    public function find($id) {
        return $this->paymentInterface->find($id);
    }

    public function create(array $data) {
        return $this->paymentInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->paymentInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->paymentInterface->destroy($id);
    }
    
    public function payment(array $data)
    {
        return $this->paymentInterface->payment($data);
    }        
    public function redeemAmount($id)
    {
        return $this->paymentInterface->redeemAmount($id);
    }
    
    public function redeemAmountForBooking($booking_id)
    {
        return $this->paymentInterface->redeemAmountForBooking($booking_id);
    }
    
    public function findBookingPayment($id) {
        return $this->paymentInterface->findBookingPayment($id);
    }
}
