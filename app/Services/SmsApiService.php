<?php

namespace App\Services;

require app_path() . "/Includes/Smsgh/Api.php";

use App\Repositories\SMSAPI\SmsApiInterface as SmsApiInterface;
use App\Includes\Smsgh\ApiHost;
use App\Includes\Smsgh\Message;
use App\Includes\Smsgh\MessagingApi;
use App\Includes\Smsgh\BasicAuth;
use App\Includes\Smsgh\MessageResponse;

class SmsApiService extends BaseService {

    protected $smsApiInterface;

    public function __construct(SmsApiInterface $smsApiInterface) {
        $this->smsApiInterface = $smsApiInterface;
    }

    public function sendVerificationCode($user) {
        // API Parameters (Required)
        $verification_code = mt_rand(100000, 999999);
        $country_code = (isset($user->mobile_country_code) && $user->mobile_country_code) ? $user->mobile_country_code : '+233';
        $mobile = $user->mobile;

        // The environment is production
        $environment = env('APP_ENV');
        if ($environment == 'production') {
            $mobile = ltrim($mobile, '0');
            $sender_id = '+233504970929';
            $content = 'Here is your Uncle Fitter activation code: ' . $verification_code;
            $client_id = 'vroeggwm';
            $client_secret = 'fbsbvkjx';
            $basic_auth = new BasicAuth($client_id, $client_secret);
            $api = new ApiHost($basic_auth);
            $api->setContextPath("v1");
            $message = new Message();
            $message->setFrom($sender_id);
            $message->setTo($country_code . $mobile);
            $message->setContent($content);
            $msg_api = new MessagingApi($api, false);
            $msg_api->sendQuickMessage($sender_id, $country_code . $mobile, $content);
            //$message->setRegisteredDelivery(false);
            /*
              $response = $msg_api->sendMessage($message);
              dd($response);
             */
        }
        $this->smsApiInterface->sendVerificationCode($user, $verification_code);
        return $verification_code;
    }
    
    public function sendOTPCode($user) {
        // API Parameters (Required)
        $verification_code = mt_rand(100000, 999999);
        $country_code = (isset($user->mobile_country_code) && $user->mobile_country_code) ? $user->mobile_country_code : '+233';
        $mobile = $user->mobile;

        // The environment is production
        $environment = env('APP_ENV');
        if ($environment == 'production') {
            $mobile = ltrim($mobile, '0');
            $sender_id = '+233504970929';
            $content = 'Here is your Uncle Fitter activation code: ' . $verification_code;
            $client_id = 'vroeggwm';
            $client_secret = 'fbsbvkjx';
            $basic_auth = new BasicAuth($client_id, $client_secret);
            $api = new ApiHost($basic_auth);
            $api->setContextPath("v1");
            $message = new Message();
            $message->setFrom($sender_id);
            $message->setTo($country_code . $mobile);
            $message->setContent($content);
            $msg_api = new MessagingApi($api, false);
            $msg_api->sendQuickMessage($sender_id, $country_code . $mobile, $content);
            //$message->setRegisteredDelivery(false);
            /*
              $response = $msg_api->sendMessage($message);
              dd($response);
             */
        }
        return $verification_code;
    }

}

?>