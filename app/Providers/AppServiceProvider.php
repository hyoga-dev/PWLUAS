<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Jika aplikasi diakses melalui HTTPS (Ngrok) atau URL mengandung 'ngrok'
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || str_contains(config('app.url'), 'ngrok')) {
            // 1. Paksa semua link menjadi https://
            URL::forceScheme('https');
            
            // 2. Paksa root domain menggunakan APP_URL dari file .env
            URL::forceRootUrl(config('app.url'));
        }
    }
}