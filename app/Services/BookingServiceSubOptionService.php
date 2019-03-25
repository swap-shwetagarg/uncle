<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 10:40 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BookingServiceSubOption\BookingServiceSubOptionInterface as BookingServiceSubOptionInterface;

class BookingServiceSubOptionService extends BaseService {

    protected $bookingServiceSubOptionInterface;

    public function __construct(BookingServiceSubOptionInterface $bookingServiceSubOptionInterface) {
        $this->bookingServiceSubOptionInterface = $bookingServiceSubOptionInterface;
    }

    public function findAll() {
        return $this->bookingServiceSubOptionInterface->findAll();
    }

    public function find($id) {
        return $this->bookingServiceSubOptionInterface->find($id);
    }

    public function create(array $data) {
        return $this->bookingServiceSubOptionInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->bookingServiceSubOptionInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->bookingServiceSubOptionInterface->destroy($id);
    }

}
