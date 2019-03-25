<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\SubServiceOptions\SubServiceOptInterface as SubServiceOptInterface;

class SubServiceOptService extends BaseService {

    protected $subserviceoptInterface;

    public function __construct(SubServiceOptInterface $subserviceoptInterface) {
        $this->subserviceoptInterface = $subserviceoptInterface;
    }

    public function findAll() {
        return $this->subserviceoptInterface->findAll();
    }

    public function find($id) {
        return $this->subserviceoptInterface->find($id);
    }

    public function create(array $data) {
        return $this->subserviceoptInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->subserviceoptInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->subserviceoptInterface->destroy($id);
    }

    public function getOptionsFromId($id) {
        return $this->subserviceoptInterface->getOptionsFromId($id);
    }

    public function getSubServicesOptuionsBySService($sservice_id) {
        return $this->subserviceoptInterface->getSubServicesOptuionsBySService($sservice_id);
    }

}
