<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Api\Exception\ApiValidationException;
use App\Domain\Api\Exception\NoAccessException;
use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStateEnum;
use App\Domain\Trip\Exception\TripNotFoundExecption;
use App\Domain\Trip\Jobs\PostTripJob;
use App\Domain\Trip\Model\Trip;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Domain\Shared\Responses\ApiEloquentSucessResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDeviceController extends Controller
{
    public function testConnection(Request $request): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Connection established'
        ]);
    }
}
