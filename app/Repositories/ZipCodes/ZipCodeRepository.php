<?php

// app/Repositories/ZipCodeRepoClass.php

namespace App\Repositories\ZipCodes;

use App\Models\ZipCode;
use App\Repositories\ZipCodes\ZipCodeInterface as ZipCodeInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\StatusFlag;

class ZipCodeRepository implements ZipCodeInterface {

    protected $zipcode;

    public function __construct(ZipCode $zipcode) {
        $this->zipcode = $zipcode;
    }

    public function find($data) {
        return $this->zipcode->select('id', 'zip_code', 'country_code', 'service_availability')
                        ->whereZip_code($data)
                        ->whereCountry_codeOrId($data, $data)
                        ->get();
    }

    public function findAll($flag = 0) {
        if ($flag) {
            $collection = $this->zipcode->select('id', 'zip_code', 'country_code', 'service_availability')
                    ->whereStatusAndService_availability(StatusFlag::ACTIVE, 1)
                    ->orderBy('zip_code', 'ASC')
                    ->get();
            return $collection;
        } else {
            return $this->zipcode->paginate(15);
        }
    }

    public function create(array $data) {
        try {
            return $this->zipcode->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function update(array $data, $id) {
        try {

            return $this->zipcode->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->zipcode->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
