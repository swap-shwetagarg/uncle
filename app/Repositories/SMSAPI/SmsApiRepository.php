<?php

namespace App\Repositories\SMSAPI;

use App\User;
use App\Repositories\SMSAPI\SmsApiInterface;
use Illuminate\Support\Facades\Log;

class SmsApiRepository implements SmsApiInterface {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    // Send Verification Code to the User's Mobile Number for Verify thier account
    public function sendVerificationCode($user = '', $verification_code = 0) {
        $id = $user->id;
        $data = ['verification_code' => $verification_code];
        try {
            return $this->user->findOrFail($id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}

?>