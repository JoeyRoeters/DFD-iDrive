<?php

namespace App\Infrastructure\Laravel\Exceptions;

use App\Domain\Api\Exception\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof ApiException) {
                $e->handle();
            }

            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
