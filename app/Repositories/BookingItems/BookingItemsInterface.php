<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 8:53 PM
 */

namespace App\Repositories\BookingItems;

interface BookingItemsInterface {

    //put your code here
    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function deleteBookingItems($booking_id);
}
