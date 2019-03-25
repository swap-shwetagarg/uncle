<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\DeviceTokens\DeviceTokensInterface as DeviceTokensInterface;

class DeviceTokensService extends BaseService {

    protected $deviceTokensInterface;

    public function __construct(DeviceTokensInterface $deviceTokensInterface) {
        $this->deviceTokensInterface = $deviceTokensInterface;
    }

    public function find($device_token) {
        return $this->deviceTokensInterface->find($device_token);
    }

    public function create(array $data) {
        return $this->deviceTokensInterface->create($data);
    }

    public function destroy($device_token) {
        return $this->deviceTokensInterface->destroy($device_token);
    }

}
