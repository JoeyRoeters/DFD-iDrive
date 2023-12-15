<?php

namespace App\Helpers\ApiToken;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiTokenUtils
{
    private const KEY = 'api_token_key';

    public static function generateToken(string $apiKey, string $deviceId): string
    {
        $hashedDeviceId = hash('sha256', $deviceId);

        $payload = [
            'api_key' => $apiKey,
            'hashed_device_id' => $hashedDeviceId,
            'device_id' => $deviceId,
        ];

        return JWT::encode($payload, self::KEY, 'HS256');
    }

    public static function decodeToken(string $token): ?array
    {
        try {
            return (array) JWT::decode($token, new Key(self::KEY, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
