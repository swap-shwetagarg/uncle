<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ClientRequest {

    public static function clientRequstGet($url, $basic, $data) {
        $client = new Client(['headers' => ['Accept' => 'application/json', 'Authorization' => $basic]]);
        $response = $client->get($url . '/' . $data);
        return $response;
    }

    public static function clientRequst($url, $basic, $data) {
        
        Log::useDailyFiles(storage_path() . '/logs/debug.log');
        Log::info(["URL: " . $url . " Basic Auth: " . $basic . " Data: " . json_encode($data) . "}"]);
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . $basic,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        Log::info(["Headers: " . json_encode($headers)]);
        
        $client = new Client(['headers' => $headers]);
        $response = $client->post($url, [json_encode($data)]);
        return $response;
    }

}
