<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 9:05 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Address\AddressInterface as AddressInterface;

class AddressService extends BaseService {

    protected $addressInterface;

    public function __construct(AddressInterface $addressInterface) {
        $this->addressInterface = $addressInterface;
    }

    public function findAll() {
        return $this->addressInterface->findAll();
    }

    public function find($id) {
        return $this->addressInterface->find($id);
    }

    public function create(array $data) {
        return $this->addressInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->addressInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->addressInterface->destroy($id);
    }

}
