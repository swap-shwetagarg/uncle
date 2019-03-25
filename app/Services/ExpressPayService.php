<?php

namespace App\Services;

use AppSettings;

class ExpressPayService extends BaseService {

    public $isSendBox = true;

    public function __construct() {
        $this->isSendBox = env('EXP_IS_SANDBOX');
    }

    public function GetToken($booking, $amount,$default = 1) {
        AppSettings::set('merchant_id', '5789595f9acf605eb2.36762238595f9');
        AppSettings::set('api_key', 'QhGzu1qY5yp5VYf0fY5Dj-Zq0i0cN2RMBR3XZRsFQ9-MJAv6DkyToNN0kHJJAk0-vXlu6vV5SfLwB8hhRm2');
        if($default){
            $url = url('user/express-callback-pay');
        }else{
            $url = url('api/user/express-callback-pay-app?redirect='.$booking->redirecturl);
        }
        $server_output = '';
        if ($booking) {
            $data = array(
                'merchant-id' => AppSettings::get('merchant_id'),
                'api-key' => AppSettings::get('api_key'),
                'firstname' => $booking->getUser->name,
                'lastname' => $booking->getUser->name,
                'email' => $booking->getUser->email,
                'phonenumber' => $booking->getUser->mobile,
                'currency' => 'GHS',
                'amount' => $amount,
                'order-id' => $booking->id,
                'redirect-url' => $url,
                'post-url' => $url
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            if ($this->isSendBox)
                $server_output = file_get_contents('https://sandbox.expresspaygh.com/api/submit.php', false, $context);
            else
                $server_output = file_get_contents('https://expresspaygh.com/api/submit.php', false, $context);
        }
        return $server_output;
    }

    public function GetResponse($request) {
        $data = array(
            'merchant-id' => AppSettings::get('merchant_id'),
            'api-key' => AppSettings::get('api_key'),
            'token' => $request->token
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        if ($this->isSendBox)
            $server_responce = \GuzzleHttp\json_decode(file_get_contents('https://sandbox.expresspaygh.com/api/query.php', false, $context));
        else
            $server_responce = \GuzzleHttp\json_decode(file_get_contents('https://expresspaygh.com/api/query.php', false, $context));

        return $server_responce;
    }

}
