<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use GuzzleHttp\Client;

/**
 * Description of SocialiteCheck
 *
 * @author vishal
 */
class SocialiteCheck extends Helpers {
    
    public static function getFacebookUserByToken($token)
    {
        $meUrl = 'https://graph.facebook.com/v2.9/me?access_token='.$token.'&fields=';

        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ]]);
        
        try {
                $response = $client->get($meUrl);
        } catch (\Exception $ex) {
            return false;
        }

        return json_decode($response->getBody(), true);
    }
    
    public static function getGoogleUserByToken($token)
    {
        $client = new Client([
            'query' => [
                'prettyPrint' => 'false',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);
        
        try {
                $response = $client->get('https://www.googleapis.com/plus/v1/people/me?');
        } catch (\Exception $ex) {
            return false;
        }
        

        return json_decode($response->getBody(), true);
    }
}
