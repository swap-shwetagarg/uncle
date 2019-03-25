<?php

namespace App\Repositories\SMSAPI;

interface SmsApiInterface {

    public function sendVerificationCode($user = '', $verification_code = 0);
}

?>