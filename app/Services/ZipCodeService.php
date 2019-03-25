<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\ZipCodes\ZipCodeInterface as ZipCodeInterface;

class ZipCodeService extends BaseService {

    protected $zipcodeInterface;

    public function __construct(ZipCodeInterface $zipcodeInterface) {
        $this->zipcodeInterface = $zipcodeInterface;
    }

    public function findAll($flag = 0) {
        return $this->zipcodeInterface->findAll($flag);
    }

    public function find($id) {
        return $this->zipcodeInterface->find($id);
    }

    public function create(array $data) {
        return $this->zipcodeInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->zipcodeInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->zipcodeInterface->destroy($id);
    }

}
