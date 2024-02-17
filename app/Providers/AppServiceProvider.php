<?php

namespace App\Providers;

use App\CentralLogics\Helpers;
use App\Model\BusinessSetting;
use App\Traits\SystemAddonTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

ini_set('memory_limit', '-1');

class AppServiceProvider extends ServiceProvider
{
    use SystemAddonTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    

        try {
            $timezone = BusinessSetting::where(['key' => 'time_zone'])->first();
            if (isset($timezone)) {
                config(['app.timezone' => $timezone->value]);
                date_default_timezone_set($timezone->value);
            }
        }catch(\Exception $exception){}

        Paginator::useBootstrap();
    }
}
