<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Cars\CarsInterface as CarsInterface;

class CarService extends BaseService {

    protected $carInterface;

    public function __construct(CarsInterface $carInterface) {
        $this->carInterface = $carInterface;
    }

    public function findAll($flag = 0) {
        return $this->carInterface->findAll($flag);
    }

    public function find($id) {
        return $this->carInterface->find($id);
    }

    public function create(array $data) {
        return $this->carInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->carInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->carInterface->destroy($id);
    }

}
