<?php

namespace App\Repositories\CarTrim;

use App\Models\CarTrim;
use App\Repositories\CarTrim\CarTrimInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class CarTrimRepository implements CarTrimInterface {

    protected $cartrim;

    public function __construct(CarTrim $cartrim) {
        $this->cartrim = $cartrim;
    }

    public function find($id) {
        return $this->cartrim->select('id', 'car_model_id', 'car_trim_name', 'status')
                        ->whereIdOrCar_trim_name($id,$id)
                        ->get();
    }

    public function findAll($flag=0) {
        if ($flag) {
            return $this->cartrim->select('id', 'car_model_id', 'car_trim_name', 'status')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        } else {
            return $this->cartrim->paginate(15);
        }
    }

    public function create(array $data) {
        try {
            return $this->cartrim->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {
            return $this->cartrim->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->cartrim->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
