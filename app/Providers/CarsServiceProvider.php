<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CarsServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('App\Repositories\Cars\CarsInterface', 'App\Repositories\Cars\CarsRepository');
    }

}
