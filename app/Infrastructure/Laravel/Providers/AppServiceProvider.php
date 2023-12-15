<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Domain\Trip\Jobs\PostTripJob;
use App\Domain\Trip\Model\Trip;
use Illuminate\Foundation\Application;
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

        // Bind the Trip model to the PostTripJob class
        $this->app->bind(PostTripJob::class, function ($app) {
            return new PostTripJob($app->make(Trip::class));
        });

        $this->app->bind(PostTripJob::class, fn (PostTripJob $job, Application $app) => $job->handle($app->make(Trip::class)));
    }
}
