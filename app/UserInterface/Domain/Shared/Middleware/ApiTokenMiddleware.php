<?php

namespace App\UserInterface\Domain\Shared\Middleware;

use App\Domain\User\Model\User;
use App\Helpers\ApiToken\ApiTokenUtils;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Validate if X-API-TOKEN exists in the request headers
        if (!$request->hasHeader('X-API-TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Extract and decode the token
        $token = $request->header('X-API-TOKEN');
        $decodedToken = ApiTokenUtils::decodeToken($token);

        // Validate the token structure
        if (!$decodedToken || !isset($decodedToken['api_key']) || !isset($decodedToken['device_id'])) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Validate the token against the user's API key and hashed device_id
        $user = User::where('api_key', $decodedToken['api_key'])->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        auth()->setUser($user);

        $hashedDeviceId = hash('sha256', $decodedToken['device_id']);
        if ($decodedToken['hashed_device_id'] !== $hashedDeviceId) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $deviceAccess = $user->devices()->where('_id', $decodedToken['device_id']);
        if (!$deviceAccess->exists()) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $request->merge(['device', $deviceAccess->first()]);

        return $next($request);
    }
}
