<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Models\ModelInterface as ModelInterface;

class ModelService extends BaseService {

    protected $modelInterface;

    public function __construct(ModelInterface $modelInterface) {
        $this->modelInterface = $modelInterface;
    }

    public function findAll($flag = 0) {
        return $this->modelInterface->findAll($flag);
    }

    public function find($id) {
        return $this->modelInterface->find($id);
    }

    public function create(array $data) {
        return $this->modelInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->modelInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->modelInterface->destroy($id);
    }

}
