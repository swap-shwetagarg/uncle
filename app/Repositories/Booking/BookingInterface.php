<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories\Booking;

/**
 *
 * @author vishal
 */
interface BookingInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();

    public function findByStatus($status);
    
    public function searchWithStatus($status,$booking_id,$user_name); 

    public function userBookings($status, $user_id);
}
