<?php

namespace App\Providers;

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
        // Cargar helpers personalizados
        require_once app_path('Helpers/UrlHelper.php');
        require_once app_path('Helpers/StorageHelper.php');
        
        // Forzar HTTPS en producción
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
