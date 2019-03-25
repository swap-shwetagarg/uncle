<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RatingServiceProvider extends ServiceProvider {

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
        $this->app->bind('App\Repositories\Rating\RatingInterface', 'App\Repositories\Rating\RatingRepository');
    }

}
