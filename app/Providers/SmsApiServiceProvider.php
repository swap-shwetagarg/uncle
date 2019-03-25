<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SmsApiServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    public function boot() {
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('App\Repositories\SMSAPI\SmsApiInterface', 'App\Repositories\SMSAPI\SmsApiRepository');
    }

}
