<?php

namespace App\Providers;

use App\AwemeUser;
use App\Helpers\DouYin\MediaQrCodeLogin;
use App\Observers\AwemeUserObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        AwemeUser::observe(AwemeUserObserver::class);
    }
}
