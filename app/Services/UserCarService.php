<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\UserCar\UserCarInterface as UserCarInterface;

Class UserCarService extends BaseService {

    protected $userCarInterface;

    public function __construct(UserCarInterface $userCarInterface) {

        $this->userCarInterface = $userCarInterface;
    }

    public function findAll() {
        return $this->userCarInterface->findAll();
    }

    public function find($id) {
        return $this->userCarInterface->find($id);
    }

    public function create(Array $data) {
        return $this->userCarInterface->create($data);
    }

    public function update(Array $data, $id) {
        return $this->userCarInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->userCarInterface->destroy($id);
    }
    
    public function getUserCarById($id) {
        return $this->userCarInterface->getUserCarById($id);
    }
    
    public function getUserCarServices($id) {
        return $this->userCarInterface->getUserCarServices($id);
    }
    public function getUserCarDetails(Array $param) {
        return $this->userCarInterface->getUserCarDetails($param);
    }
    
    public function softDelete($id) {
        return $this->userCarInterface->softDelete($id);
    }

}
