<?php

namespace App\Repositories\DeviceTokens;

use App\Models\DeviceTokens;
use Illuminate\Support\Facades\Log;
use App\Repositories\DeviceTokens\DeviceTokensInterface;
use Auth;

class DeviceTokensRepository implements DeviceTokensInterface {

    protected $deviceTokens;

    public function __construct(DeviceTokens $deviceTokens) {
        $this->deviceTokens = $deviceTokens;
    }

    public function find() {
        $user_id = Auth::user()->id;
        return $this->deviceTokens->select('id', 'device', 'user_id', 'device_token', 'created_at', 'updated_at', 'remember_token', 'status')
                        ->whereUser_id($user_id)
                        ->whereStatus(1)
                        ->get();
    }

    public function create(Array $data) {
        try {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $data]);
            return $this->deviceTokens->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($device_token = null) {
        try {
            $whereArray = array('device_token' => $device_token);
            return $this->deviceTokens->where($whereArray)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}

?>