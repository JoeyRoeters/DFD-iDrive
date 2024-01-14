<?php

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        $this->loadUserInterfaceRoutes();
    }

    /**
     * Load routes from the app/UserInterface directory.
     *
     * @return void
     */
    protected function loadUserInterfaceRoutes()
    {
        $routeDirectories = glob(base_path('app/UserInterface/Domain/**/Routes'), GLOB_ONLYDIR);

        foreach ($routeDirectories as $directory) {
            $this->loadRoutesFromDirectory($directory);
        }
    }

    /**
     * Load routes from a specific directory.
     *
     * @param string $directory
     * @return void
     */
    protected function loadRoutesFromDirectory(string $directory)
    {
        // base name of 1 dir back
        $directoryName = strtolower(basename(dirname($directory)));

        // make sure the directory name is plural
        $directoryName = str_ends_with($directoryName, 's') ? $directoryName : $directoryName . 's';

        $webRouteFile = $directory . '/web.php';
        $apiRouteFile = $directory . '/api.php';

        if (file_exists($webRouteFile)) {
            $middleware = ['web'];

            $unAuthenticatedDomains = [
                'auths'
            ];

            if (!in_array($directoryName, $unAuthenticatedDomains)) {
                $middleware[] = 'auth';
                $middleware[] = 'verified';
            }

            Route::middleware($middleware)
                ->prefix($directoryName)
                ->group($webRouteFile);
        }

        if (file_exists($apiRouteFile)) {
            Route::middleware('api')
                ->prefix('api/' . $directoryName)
                ->group($apiRouteFile);
        }
    }
}
