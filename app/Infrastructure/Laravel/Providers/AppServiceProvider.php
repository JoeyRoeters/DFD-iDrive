<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Helpers\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\Redirect;
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
