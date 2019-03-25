<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $environment = env('APP_ENV');
        if ($environment == 'production') {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        Validator::extend("emails", function($attribute, $values, $parameters) {
            $value = explode(',', $values);
            $rules = [
                'email' => 'required|email',
            ];
            if ($value) {
                foreach ($value as $email) {
                    $data = [
                        'email' => $email
                    ];
                    $validator = \Validator::make($data, $rules);
                    if ($validator->fails()) {
                        return false;
                    }
                }
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
