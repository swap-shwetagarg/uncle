<?php

namespace App\Repositories\Years;

use App\Models\Years;
use App\Repositories\Years\YearInterface as YearInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class YearsRepository implements YearInterface {

    protected $years;

    public function __construct(Years $years) {
        $this->years = $years;
    }

    public function find($id) {
        $id = (int) $id;
        return $this->years->select('id', 'year', 'car_id', 'status')
                        ->whereIdOrYear($id, $id)
                        ->get();
    }
    
    public function findById($id) {
        $id = (int) $id;
        return $this->years->select('id', 'year', 'car_id', 'status')
                        ->whereId($id)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->years->select('id', 'year', 'car_id', 'status')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        } else {
            return $this->years->paginate(15);
        }
    }

    public function create(array $data) {
        try {
            return $this->years->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {
            return $this->years->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->years->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
