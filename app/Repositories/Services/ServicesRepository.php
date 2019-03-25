<?php

// app/Repositories/ServicesRepoClass.php

namespace App\Repositories\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Services;
use App\Repositories\Services\ServicesInterface;
use App\Utility\StatusFlag;

class ServicesRepository implements ServicesInterface {

    protected $model;

    public function __construct(Services $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                        ->whereIdOrTitle($id, $id)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        } else {
            return $this->model->paginate(15);
        }
    }

    public function create(array $data) {
        try {
            return $this->model->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {
            return $this->model->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->model->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function getInspectionServices() {
        return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                        ->whereStatusAndCategory_id(StatusFlag::ACTIVE, 3)
                        ->get();
    }

    public function getPopularServices() {
        $popular_service_array = $this->getPopularServiceIds();
        $popular_service_collection = Services::whereIn('id', $popular_service_array)->get();
        return $popular_service_collection;
    }

    public function getPopularServiceIds() {
        /*
          $popular_service = \DB::table('booking_items')
          ->select(\DB::raw('service_id, count(service_id) as service_count'))
          ->groupBy('service_id')
          ->orderByRaw('service_count DESC')
          ->limit(10)
          ->get();
         */
        $popular_service = \DB::table('services')
                ->select(\DB::raw('id, is_popular'))
                ->where('is_popular', '1')
                ->get();
        return $popular_service->pluck('id')->toArray();
    }

    public function searchServices($search = null, $type = null) {
        if ($search) {
            if ($type && $type == 'repair') {
                return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                                ->where('title', 'like', '%' . $search . '%')
                                ->whereNotIn('category_id', array(2, 3))
                                ->get();
            } elseif ($type && $type == 'diagnostic') {
                return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                                ->where('title', 'like', '%' . $search . '%')
                                ->whereIn('category_id', array(2, 3))
                                ->get();
            } else {
                return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                                ->where('title', 'like', '%' . $search . '%')
                                ->get();
            }
        }
        return false;
    }

    public function searchAllServices($search = null) {
        if ($search) {
            return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                            ->where('title', 'like', '%' . $search . '%')
                            ->whereNotIn('category_id', array(2))
                            ->get();
        }
        return false;
    }

    public function getServicesByCategory($category_id) {
        return $this->model->select('id', 'category_id', 'title', 'description', 'recommend_service_id', 'is_popular')
                        ->where('category_id', $category_id)
                        ->where('status', 1)
                        ->get();
    }

}
