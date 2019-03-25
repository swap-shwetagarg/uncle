<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Description of UserCarServiceProvider
 *
 * @author virendra
 * 
 */
class UserCarServiceProvider extends ServiceProvider {

    //put your code here

    public function boot() {
        
    }

    public function register() {
        $this->app->bind('App\Repositories\UserCar\UserCarInterface', 'App\Repositories\UserCar\UserCarRepository');
    }

}
