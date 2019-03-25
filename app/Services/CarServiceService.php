<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Services\ServicesInterface as ServicesInterface;

class CarServiceService extends BaseService {

    protected $serviceInterface;

    public function __construct(ServicesInterface $serviceInterface) {
        $this->serviceInterface = $serviceInterface;
    }

    public function findAll($flag = 0) {
        return $this->serviceInterface->findAll($flag);
    }

    public function find($id) {
        return $this->serviceInterface->find($id);
    }

    public function create(array $data) {
        return $this->serviceInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->serviceInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->serviceInterface->destroy($id);
    }

    public function getInspectionServices() {
        return $this->serviceInterface->getInspectionServices();
    }

    public function getPopularServices() {
        return $this->serviceInterface->getPopularServices();
    }

    public function getPopularServiceIds() {
        return $this->serviceInterface->getPopularServiceIds();
    }

    public function searchServices($search = null, $type = null) {
        return $this->serviceInterface->searchServices($search, $type);
    }
    
    public function searchAllServices($search = null, $type = null) {
        return $this->serviceInterface->searchAllServices($search);
    }
    
    public function getServicesByCategory($category_id) {
        return $this->serviceInterface->getServicesByCategory($category_id);
    }
}
