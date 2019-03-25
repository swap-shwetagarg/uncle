<?php

namespace App\Repositories\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Log;
use App\Repositories\Address\AddressInterface;

class AddressRepository implements AddressInterface {

    protected $address;

    public function __construct(Address $address) {
        $this->address = $address;
    }

    public function find($data) {
        return $this->address->select('id', 'user_id', 'add_1','add_2','zipcode','area','country')
                        ->whereId($data)
                        ->get();
    }

    public function findAll() {
        return $this->address->paginate(15);
    }

    public function create(Array $data) {
        try {
            return $this->address->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(Array $data, $id) {
        try {
            return $this->address->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->address->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}

?>