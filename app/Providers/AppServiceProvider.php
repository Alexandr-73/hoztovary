<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Принудительно генерируем HTTPS-ссылки для продакшн-окружения
    // if ($this->app->environment('production')) {
        URL::forceScheme('https');
    //  }
    }
}
