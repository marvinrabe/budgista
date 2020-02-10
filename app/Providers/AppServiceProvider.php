<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->toW3cString();
        });

        Blade::if('track', function () {
            return !(isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1);
        });

        Blade::if('donottrack', function () {
            return (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1);
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
