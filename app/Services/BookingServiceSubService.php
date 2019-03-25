<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 9:56 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BookingServiceSub\BookingServiceSubInterface as BookingServiceSubInterface;

class BookingServiceSubService extends BaseService {

    protected $bookingServiceSubInterface;

    public function __construct(BookingServiceSubInterface $bookingServiceSubInterface) {
        $this->bookingServiceSubInterface = $bookingServiceSubInterface;
    }

    public function findAll() {
        return $this->bookingServiceSubInterface->findAll();
    }

    public function find($id) {
        return $this->bookingServiceSubInterface->find($id);
    }

    public function create(array $data) {
        return $this->bookingServiceSubInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->bookingServiceSubInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->bookingServiceSubInterface->destroy($id);
    }

}
