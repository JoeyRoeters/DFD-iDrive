<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Trip\Model\Trip;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Domain\Shared\Responses\ApiEloquentSucessResponse;
use Illuminate\Http\Request;

class ApiTripController extends Controller
{
    public function create(Request $request): ApiEloquentSucessResponse
    {
        $device = $request->get('device');
        $user = $request->get('user');

        $trip = new Trip([
            'user_id' => $user->id,
            'device_id' => $device->id,
            'trip_number' => $user->trips()->count() + 1,
        ]);

        $trip->save();

        return new ApiEloquentSucessResponse($trip);
    }
}
