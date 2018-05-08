<?php

namespace Selfreliance\SharesRateAdmin;

use Illuminate\Support\ServiceProvider;

class SharesRateAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__.'/routes.php';
        $this->app->make('Selfreliance\SharesRateAdmin\SharesRateAdminController');
        $this->loadViewsFrom(__DIR__.'/views', 'sharesrateadmin');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}