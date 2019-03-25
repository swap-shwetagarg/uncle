<?php

namespace App\Repositories\Models;

use App\Models\CarsModel;
use App\Repositories\Models\ModelInterface as ModelInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class ModelRepository implements ModelInterface {

    protected $model;

    public function __construct(CarsModel $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->select('id', 'year_id', 'modal_name')
                        ->whereIdOrModal_name($id,$id)
                        ->get();
    }

    public function findAll($flag=0) {
        if($flag){
            return $this->model->select('id', 'year_id', 'modal_name', 'status')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        }else{
            return $this->model->paginate(15);
        }      
    }

    public function create(array $data) {
        return $this->model->insert($data);
        try {
            
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
