<?php

namespace App\UserInterface\Domain\Shared\Middleware;

use App\Domain\Api\Exception\InvalidCredentialsException;
use App\Domain\Api\Exception\NoAccessException;
use App\Domain\Api\Util\ApiTokenUtils;
use App\Domain\User\Model\User;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Validate if X-API-TOKEN exists in the request headers
        if (!$request->hasHeader('X-API-TOKEN')) {
            throw new InvalidCredentialsException();
        }

        // Extract and decode the token
        $token = $request->header('X-API-TOKEN');
        $decodedToken = ApiTokenUtils::decodeToken($token);

        // Validate the token structure
        if (!$decodedToken || !isset($decodedToken['api_key']) || !isset($decodedToken['device_id'])) {
            throw new InvalidCredentialsException();
        }

        // Validate the token against the user's API key and hashed device_id
        $user = User::where('api_key', $decodedToken['api_key'])->first();
        if (!$user) {
            throw new InvalidCredentialsException();
        }

        auth()->setUser($user);

        $hashedDeviceId = hash('sha256', $decodedToken['device_id']);
        if ($decodedToken['hashed_device_id'] !== $hashedDeviceId) {
            throw new InvalidCredentialsException();
        }

        $deviceAccess = $user->devices()->where('_id', $decodedToken['device_id']);
        if (!$deviceAccess->exists()) {
            throw new NoAccessException();
        }

        $request->merge([
            'user' => $user,
            'device' => $deviceAccess->first()
        ]);

        return $next($request);
    }
}
