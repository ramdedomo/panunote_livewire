<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
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
        if(env('APP_ENV') !== 'local')
        {
            URL::forceScheme('https');
        }

        date_default_timezone_set('Asia/Manila');
        Paginator::useBootstrapFive();
        View::composer(['layouts.panunote_master'], 'App\Http\VIew\Composers\UserDetailsComposer');
    }
}
