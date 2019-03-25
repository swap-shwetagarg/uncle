<?php

namespace App\Repositories\SubServiceOptions;

use App\Models\SubServicesOptions;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class SubServicesOptRepository implements SubServiceOptInterface {

    protected $model;

    public function __construct(SubServicesOptions $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->select('id', 'option_name', 'option_description', 'option_order', 'sub_service_id', 'sub_service_id_ref', 'recommend_service_id', 'option_type', 'option_image')
                        ->whereId($id)
                        ->get();
    }

    public function getOptionsFromId($id) {
        return $this->model->select('id', 'option_name', 'option_description', 'option_order', 'sub_service_id', 'sub_service_id_ref', 'recommend_service_id', 'option_type', 'option_image')
                        ->whereIn('id', $id)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->model->select('id', 'option_name', 'option_description', 'option_order', 'sub_service_id', 'sub_service_id_ref', 'recommend_service_id', 'option_type', 'option_image')
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

    public function getSubServicesOptuionsBySService($sservice_id) {
        return $this->model->select('id', 'option_name', 'option_description', 'option_order', 'sub_service_id', 'sub_service_id_ref', 'recommend_service_id', 'option_type', 'option_image')
                        ->where('sub_service_id', $sservice_id)
                        ->where('status', 1)
                        ->get();
    }

}
