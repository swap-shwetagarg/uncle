<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\ServiceType\ServiceTypeInterface as ServiceTypeInterface;

class ServiceTypeService extends BaseService {

    protected $servicetypeInterface;

    public function __construct(ServiceTypeInterface $servicetypeInterface) {
        $this->servicetypeInterface = $servicetypeInterface;
    }

    public function findAll($flag=0) {
        return $this->servicetypeInterface->findAll($flag);
    }

    public function find($id) {
        return $this->servicetypeInterface->find($id);
    }

    public function create(array $data) {
        return $this->servicetypeInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->servicetypeInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->servicetypeInterface->destroy($id);
    }

}