<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 11:05 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BookingMechanic\BookingMechanicInterface as BookingMechanicInterface;

class BookingMechanicService {

    protected $bookingMechanicInterface;

    public function __construct(BookingMechanicInterface $bookingMechanicInterface) {
        $this->bookingMechanicInterface = $bookingMechanicInterface;
    }

    public function findAll() {
        return $this->bookingMechanicInterface->findAll();
    }

    public function find($id) {
        return $this->bookingMechanicInterface->find($id);
    }

    public function create(array $data) {
        return $this->bookingMechanicInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->bookingMechanicInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->bookingMechanicInterface->destroy($id);
    }
    
    public function getBookingMechanicById($id) {
        return $this->bookingMechanicInterface->getBookingMechanicById($id);
    }
    
    public function isMechanicAvailable($mechanic_id,$booking_id,$start_date,$end_date)
    {
        return $this->bookingMechanicInterface->isMechanicAvailable($mechanic_id,$booking_id,$start_date,$end_date);
    }
    
    public function getAvailableTimes($date)
    {
        return $this->bookingMechanicInterface->getAvailableTimes($date);
    }
    
    public function getDefaultTimes()
    {
        return $this->bookingMechanicInterface->getDefaultTimes();
    }
    
    public function getAvailableTimesByMechanicId($id,$date)
    {
        return $this->bookingMechanicInterface->getAvailableTimesByMechanicId($id,$date);
    }
    public function getAllNonRejectedMechanic($id) {
        return $this->bookingMechanicInterface->getAllNonRejectedMechanic($id);
    }

}
