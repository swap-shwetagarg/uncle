<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AppSettingsService;

/**
 * Description of AppSettingsServiceProvider
 *
 * @author Mahesh
 */
class AppSettingsServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        
    }

    public function register() {
        $this->app->singleton('appSettings', function ($app) {
            return new AppSettingsService();
        });
    }

    public function provides() {
        return ['appSettings'];
    }

}
