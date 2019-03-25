<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 8:43 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Booking\BookingInterface as BookingInterface;
use App\Models\BookingMechanic;
use App\Models\Booking;

class BookingService extends BaseService {

    protected $bookingInterface;

    public function __construct(BookingInterface $bookingInterface) {
        $this->bookingInterface = $bookingInterface;
    }

    public function findAll() {
        return $this->bookingInterface->findAll();
    }

    public function findByStatus($status) {
        return $this->bookingInterface->findByStatus($status);
    }

    public function searchWithStatus($status, $booking_id, $user_name) {
        return $this->bookingInterface->searchWithStatus($status, $booking_id, $user_name);
    }

    public function find($id) {
        return $this->bookingInterface->find($id);
    }

    public function create(array $data) {
        return $this->bookingInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->bookingInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->bookingInterface->destroy($id);
    }

    public function changeBookingStatus($id, array $status) {
        return $this->bookingInterface->update($status, $id);
    }

    public function booking(array $data) {
        return $this->bookingInterface->booking($data);
    }

    public function getBooking($id) {
        return $this->bookingInterface->getBooking($id);
    }

    public function getScheduledBookings($id, $start_date, $end_date) {
        return $this->bookingInterface->getBookingsList($id, $start_date, $end_date);
    }

    public function getAvailableMechanicList($isReassign, $booking_id, $location_id, $start_date, $end_date) {
        return $this->bookingInterface->getAvailMechanics($isReassign, $booking_id, $location_id, $start_date, $end_date);
    }

    public function getBookinglistDetails(BookingMechanic $id) {
        return $this->bookingInterface->getBookinglistDetails($id);
    }

    public function userBookings($status, $user_id) {
        return $this->bookingInterface->userBookings($status, $user_id);
    }

    public function getSingleBookingDetails(Booking $result) {
        return $this->bookingInterface->getSingleBookingDetails($result);
    }

    public function filteBookingCollection($booking_collection) {
        return $this->bookingInterface->filteBookingCollection($booking_collection);
    }

    public function checkCarStatusByBooking($booking_id) {
        return $this->bookingInterface->checkCarStatusByBooking($booking_id);
    }

    public function bookingFromAdmin(array $data) {
        return $this->bookingInterface->bookingFromAdmin($data);
    }

    public function bookingFromAdminUpdate(array $data) {
        return $this->bookingInterface->bookingFromAdminUpdate($data);
    }
}
