<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Pusher;

use Pusher;
/**
 * Description of Pusher
 *
 * @author vishal
 */
class PusherClient {
    
    public static function getPusher()
    {
        $options = array(
            'cluster' => 'ap2',
            'encrypted' => true
        );

        $pusher = new Pusher(
            '6c26c37f7618e14418f3',
            '6baabc2a807eb3e35367',
            '355180',
            $options
        );
        
        return $pusher;
    }
}
