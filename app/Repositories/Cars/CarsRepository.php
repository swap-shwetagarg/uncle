<?php

namespace App\Repositories\Cars;

use App\Models\Cars;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class CarsRepository implements CarsInterface {

    protected $cars;

    public function __construct(Cars $cars) {
        $this->cars = $cars;
    }

    public function find($data) {
        return $this->cars->select('id', 'brand', 'description', 'image_url', 'status')
                        ->whereIdOrBrand($data,$data)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            return $this->cars->select('id', 'brand', 'description', 'image_url', 'status')
                            ->whereStatus(StatusFlag::ACTIVE)
                            ->get();
        } else {
            return $this->cars->paginate(15);
        }
    }

    public function create(Array $data) {
        try {
            return $this->cars->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(Array $data, $id) {
        try {
            return $this->cars->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->cars->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}

?>
