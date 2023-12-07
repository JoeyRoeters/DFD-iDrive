<?php

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Foundation\Vite;
use App\Helpers\SweetAlert\SweetAlert;
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
        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
        // Share data with all views
        View::composer('*', function ($view) {
            if (!SweetAlert::hasMessage()) {
                return;
            }

            $view->with([
                'swal' => SweetAlert::$message?->toArray() ?? session()->get('swalData'),
            ]);
        });
    }
}
