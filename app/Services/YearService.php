<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Years\YearInterface as YearInterface;

class YearService extends BaseService {

    protected $yearInterface;

    public function __construct(YearInterface $yearInterface) {
        $this->yearInterface = $yearInterface;
    }

    public function findAll() {
        return $this->yearInterface->findAll();
    }

    public function find($id) {
        return $this->yearInterface->find($id);
    }
    
    public function findById($id) {
        return $this->yearInterface->findById($id);
    }

    public function create(array $data) {
        return $this->yearInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->yearInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->yearInterface->destroy($id);
    }

}
