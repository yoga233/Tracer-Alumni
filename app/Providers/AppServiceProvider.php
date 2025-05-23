<?php
namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
          // Set locale ke bahasa Indonesia
    Carbon::setLocale('id');
    App::setLocale('id'); // opsional, tapi recommended kalau mau konsisten

    }
}
