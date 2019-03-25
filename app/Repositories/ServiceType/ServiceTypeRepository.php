<?php

namespace App\Repositories\ServiceType;

use Illuminate\Support\Facades\Log;
use App\Models\ServicesType;
use App\Utility\StatusFlag;

class ServiceTypeRepository implements ServiceTypeInterface {

    protected $model;

    public function __construct(ServicesType $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->select('id', 'service_type')
                        ->whereIdOrService_type($id,$id)
                        ->get();
    }

    public function findAll($flag=0) {
        if($flag){
            return $this->model->select('id', 'service_type', 'status', 'remember_token', 'created_at', 'updated_at')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        }else{
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

}
