<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Category\CategoryInterface as CategoryInterface;

class CategoryService extends BaseService {

    protected $categoryInterface;

    public function __construct(CategoryInterface $categoryInterface) {
        $this->categoryInterface = $categoryInterface;
    }

    public function findAll($flag=0) {
        return $this->categoryInterface->findAll($flag);
    }

    public function find($id) {
        return $this->categoryInterface->find($id);
    }

    public function create(array $data) {
        return $this->categoryInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->categoryInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->categoryInterface->destroy($id);
    }
    
    public function getCategoryByServiceType($service_type_id) {
        return $this->categoryInterface->getCategoryByServiceType($service_type_id);
    }

}
