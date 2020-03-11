<?php

namespace App\Providers;
// use Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('alpha_spaces', function ($attribute, $value) {

            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value); 
    
        });
        Validator::extend('english', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9 .!?"-\/+_)(&*^%$#@~<>\{\}\[\]]*$/u', $value); 
        });

        Validator::extend('arabic', function ($attribute, $value) {
            return preg_match('/^[\p{Arabic}0-9 .!?"-\/+_)(&*^%$#@~<>\{\}\[\]]+$/u', $value); 
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
