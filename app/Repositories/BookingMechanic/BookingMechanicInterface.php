<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 10:48 PM
 */

namespace App\Repositories\BookingMechanic;

interface BookingMechanicInterface {

    //put your code here
    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function getBookingMechanicById($booking_id);
    
    public function isMechanicAvailable($mechanic_id,$booking_id,$start_date,$end_date);
    
    public function getAvailableTimesByMechanicId($id,$date);
    
    public function getAllNonRejectedMechanic($id);
}
