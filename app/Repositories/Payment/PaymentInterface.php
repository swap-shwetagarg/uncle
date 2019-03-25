<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 11:09 PM
 */

namespace App\Repositories\Payment;

interface PaymentInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function redeemAmount($id);
}
