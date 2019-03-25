<?php

namespace App\Repositories\DeviceTokens;

interface DeviceTokensInterface {

    public function find();

    public function create(array $data);

    public function destroy($device_token);
}
