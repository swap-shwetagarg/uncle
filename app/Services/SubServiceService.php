<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\SubService\SubServiceInterface as SubServiceInterface;

class SubServiceService extends BaseService {

    protected $subserviceInterface;

    public function __construct(SubServiceInterface $subserviceInterface) {
        $this->subserviceInterface = $subserviceInterface;
    }

    public function findAll($flag=0) {
        return $this->subserviceInterface->findAll($flag);
    }

    public function find($id) {
        return $this->subserviceInterface->find($id);
    }

    public function create(array $data) {
        return $this->subserviceInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->subserviceInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->subserviceInterface->destroy($id);
    }
    
    public function getSubServicesByService($service_id) {
        return $this->subserviceInterface->getSubServicesByService($service_id);
    }

}
