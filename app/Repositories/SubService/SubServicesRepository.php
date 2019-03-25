<?php

namespace App\Repositories\SubService;

use App\Models\SubServices;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class SubServicesRepository implements SubServiceInterface {

    protected $model;

    public function __construct(SubServices $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->select('id', 'service_id', 'title', 'description', 'order', 'selection_type', 'optional', 'display_text')
                        ->whereId($id)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->model->select('id', 'service_id', 'title', 'description', 'order', 'selection_type', 'optional', 'status', 'remember_token', 'created_at', 'updated_at', 'display_text')
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

    public function getSubServicesByService($service_id) {
        return $this->model->select('id', 'service_id', 'title', 'description', 'order', 'selection_type', 'optional', 'display_text')
                        ->where('service_id', $service_id)
                        ->where('status', 1)
                        ->get();
    }

}
