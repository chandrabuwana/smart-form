<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Schema::defaultStringLength(191);
        // Paginator::useBootstrap();
        // Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        View::addNamespace('SmartForm', module_path('SmartForm', 'resources/views'));
    }
}
