<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class CategoryRepository implements CategoryInterface {

    protected $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function find($id) {
        return $this->category->select('id', 'service_type_id', 'category_name')
                        ->whereIdOrCategory_name($id, $id)
                        ->get();
    }

    public function getCategoryByServiceType($service_type_id) {
        return $this->category->select('id', 'category_name')
                        ->where('service_type_id', '=', $service_type_id)
                        ->where('status', '=', 1)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->category->select('id', 'service_type_id', 'category_name', 'status', 'remember_token', 'created_at', 'updated_at')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        } else {
            return $this->category->paginate(15);
        }
    }

    public function create(array $data) {
        try {
            return $this->category->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {
            return $this->category->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->category->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
