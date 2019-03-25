<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 9:05 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BookingItems\BookingItemsInterface as BookingItemsInterface;

class BookingItemsService extends BaseService {

    protected $bookingItemsInterface;

    public function __construct(BookingItemsInterface $bookingItemsInterface) {
        $this->bookingItemsInterface = $bookingItemsInterface;
    }

    public function findAll() {
        return $this->bookingItemsInterface->findAll();
    }

    public function find($id) {
        return $this->bookingItemsInterface->find($id);
    }

    public function create(array $data) {
        return $this->bookingItemsInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->bookingItemsInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->bookingItemsInterface->destroy($id);
    }
    
    public function deleteBookingItems($booking_id) {
        return $this->bookingItemsInterface->deleteBookingItems($booking_id);
    }

}
