<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\OtpAuthentication\OtpAuthenticationInterface as OtpAuthenticationInterface;

class OtpAuthenticationService extends BaseService {
    protected $otpAuthenticationInterface;

    public function __construct(OtpAuthenticationInterface $otpAuthenticationInterface) {
        $this->otpAuthenticationInterface = $otpAuthenticationInterface;
    }

    public function find($id) {
        return $this->otpAuthenticationInterface->find($id);
    }

    public function create(array $data) {
        return $this->otpAuthenticationInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->otpAuthenticationInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->otpAuthenticationInterface->destroy($id);
    }   
}
