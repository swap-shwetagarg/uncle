<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Listeners;

use PushNotification;
use App\Models\DeviceTokens;
use Illuminate\Support\Facades\Log;
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

/**
 * Description of BaseListener
 *
 * @author vishal
 */
class BaseListener {

    public function sendNotification(DeviceTokens $userDevice, $messages, $role, $booking = null, $purpose = '') {
        Log::useDailyFiles(storage_path() . '/logs/debug.log');
        if ($userDevice->device === 'iOS') {
            //Log::info(['Inside sendNotification']);

            // Developer Account
            /*
              if ($role->id === 1) {
              $options = config('push-notification.uncleFitterUserproIOSP8');
              } else if ($role->id === 3) {
              $options = config('push-notification.uncleFitterMechproIOSP8');
              }
             */

            // Client's Account
            if ($role->id === 1) {
                $options = config('push-notification.uncleFitterUserProductionIOSP8');
            } else if ($role->id === 3) {
                $options = config('push-notification.uncleFitterMechProductionIOSP8');
            }

            $jws = $this->getJWS($options);

            if (!defined('CURL_HTTP_VERSION_2_0')) {
                define('CURL_HTTP_VERSION_2_0', 3);
            }

            $http2ch = curl_init();

            curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
            $message = $this->getMessage($messages);
            $token = $userDevice->device_token;

            $decode_msg = json_decode($message);

            if(!is_null($booking)){
                if($purpose == "bookingDetail"){
                    $decode_msg->aps->bookingId = $booking['id'];
                }
                if($purpose == "mechanicRating"){
                    $decode_msg->aps->bookingId = $booking['id'];
                    $mechanic = $booking->bookingMechanic->mechanic;
                    $decode_msg->aps->mechanicId = $mechanic->id;
                    $decode_msg->aps->mechanicName = $mechanic->name;
                    $decode_msg->aps->overallRating = $mechanic->getRating->avg('overall_rating');
                    $decode_msg->aps->contactNumber = $mechanic->mobile;
                    $decode_msg->aps->profileUrl = $mechanic->profile_photo;
                }
                $decode_msg->aps->tag = $purpose;
            }
            $message = json_encode($decode_msg);

            $http2_server = 'https://api.push.apple.com';
            $app_bundle_id = $options['app_bundle_id'];
            $result = $this->sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $token, $jws);

            //Log::info(['sendNotification END:' => $result]);

            curl_close($http2ch);
        } else if ($userDevice->device === 'android') {
            Log::info(['sendNotification Android START']);

            // Developer Account
            if ($role->id === 1) {
                $options = config('push-notification.uncleFitterUserproAndroid');
            } else if ($role->id === 3) {
                $options = config('push-notification.uncleFitterMechproAndroid');
            }

            // API access key from Google API's Console
            $apiKey = $options['apiKey'];

            $registrationIds = array($userDevice->device_token);
            // prep the bundle
            $message = array
                (
                'message' => $messages . '',
                //'title' => 'This is a title. title',
                //'subtitle' => 'This is a subtitle. subtitle',
                //'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate' => 1,
                'sound' => 1,
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );

            if(!is_null($booking)){
                if($purpose == "bookingDetail"){
                    $data['bookingId'] = $booking['id'];
                }
                if($purpose == "mechanicRating"){
                    $data['bookingId'] = $booking['id'];
                    $mechanic = $booking->bookingMechanic->mechanic;
                    $data['mechanicId'] = $mechanic->id;
                    $data['mechanicName'] = $mechanic->name;
                    $data['averageRating'] = $mechanic->getRating->avg('overall_rating');
                    $data['contactNumber'] = $mechanic->mobile;
                    $data['profileUrl'] = $mechanic->profile_photo;
                }
                $data['tag'] = $purpose;

                $message['data'] = $data;
            }

            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $message
            );

            $headers = array
                (
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);

            /*
              if ($role->id === 1) {
              $push = PushNotification::app('uncleFitterUserproAndroid');
              } else if ($role->id === 3) {
              $push = PushNotification::app('uncleFitterMechproAndroid');
              }
              $response = $push->to($userDevice->device_token)->send($messages . 'Go check it now');
             */

            Log::info(['sendNotification Android END' => $result]);
        }
    }

    public function sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $token, $jws) {

        $url = "{$http2_server}/3/device/{$token}";
        $headers = array(
            "apns-topic: {$app_bundle_id}",
            'Authorization: bearer ' . $jws,
            "content-type: application/json"
        );

        curl_setopt_array($http2ch, array(
            CURLOPT_URL => $url,
            CURLOPT_PORT => 443,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => 1,
        ));
        $data['result'] = curl_exec($http2ch);
        if ($data['result'] === FALSE) {
            //Log::error(['Request[05-10-2017]' => "Curl failed: " . curl_error($http2ch)]);
        }

        $data['status_code'] = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
        return $data;
    }

    public function getJWS($options) {
        $key_file = $options['private_key_path'];
        $secret = null; // If the key is encrypted, the secret must be set in this variable
        $private_key = JWKFactory::createFromKeyFile($key_file, $secret, [
                    'kid' => $options['key_id'], // The Key ID obtained from your developer account
                    'alg' => 'ES256', // Not mandatory but recommended
                    'use' => 'sig', // Not mandatory but recommended
        ]);
        $payload = [
            'iss' => $options['team_id'], //Team ID obtained from your developer account
            'iat' => time(),
        ];
        $header = [
            'alg' => 'ES256',
            'kid' => $private_key->get('kid'),
        ];
        $jws = JWSFactory::createJWSToCompactJSON(
                        $payload, $private_key, $header
        );

        return $jws;
    }

    public function getMessage($message) {
        return '{
                "aps" : {
                    "alert" : {
                        "title" : "Booking",
                        "body" : "' . $message . '"
                    },
                    "content_available": true,
                    "priority": "high",
                    "badge": 0,
                    "sound" : "default"
                },
                "acme1" : "bar",
                "acme2" : [ "bang",  "whiz" ]
            }';
    }

}
