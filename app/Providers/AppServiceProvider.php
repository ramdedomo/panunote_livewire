<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url)
    {

        if(env('APP_ENV') !== 'local')
        {
            $url->forceSchema('https');
        }

        date_default_timezone_set('Asia/Manila');
        Paginator::useBootstrapFive();
        View::composer(['layouts.panunote_master'], 'App\Http\View\Composers\UserDetailsComposer');
    }
}
