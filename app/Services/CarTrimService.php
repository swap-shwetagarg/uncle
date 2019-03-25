<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\CarTrim\CarTrimInterface as CarTrimInterface;

class CarTrimService extends BaseService {

    protected $cartrimInterface;

    public function __construct(CarTrimInterface $cartrimInterface) {
        $this->cartrimInterface = $cartrimInterface;
    }

    public function findAll($flag=0) {
        return $this->cartrimInterface->findAll();
    }

    public function find($id) {
        return $this->cartrimInterface->find($id);
    }

    public function create(array $data) {
        return $this->cartrimInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->cartrimInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->cartrimInterface->destroy($id);
    }    

}
