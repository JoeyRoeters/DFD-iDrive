<?php

namespace App\UserInterface\Domain\Trip\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTripController extends Controller
{
    public function create(Request $request): ApiEloquentSucessResponse
    {
        $device = $request->get('device');
        $user = $request->get('user');

        $trip = new Trip([
            'user_id' => $user->id,
            'device_id' => $device->id
        ]);

        $trip->save();

        return new ApiEloquentSucessResponse($trip);
    }

    public function update(Request $request, string $id): ApiEloquentSucessResponse
    {
        $trip = $this->getTrip($request, $id);

        $validator = Validator::make($request->all(), [
            'state' => 'nullable|in:' . implode(',', TripStateEnum::values()),
            'start_time' => 'nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator);
        }

        $data = $request->only(['state', 'start_time', 'end_time']);

        if (isset($data['state']) && $data['state'] === TripStateEnum::FINISHED->value) {
            $data['end_time'] = Carbon::now();
            $trip->update($data);

            PostTripJob::dispatch($trip);
        }



        return new ApiEloquentSucessResponse($trip);
    }

    public function createEvents(Request $request, string $id): ApiEloquentSucessResponse
    {
        $trip = $this->getTrip($request, $id);

        $validator = Validator::make($request->all(), [
            'events' => 'required|array',
            'events.*' => 'required|array|size:3',
            'events.*.0' => 'required|string|in:' . implode(',', TripEventEnum::values()),
            'events.*.1' => 'required|numeric',
            'events.*.2' => '',
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator);
        }

        $events = $request->get('events');

        foreach ($events as $eventData) {
            list($eventType, $timestamp, $eventData) = $eventData;
            if (!empty($eventData) && is_string($eventData)) {
                $eventData = json_decode($eventData, true) ?? [];
            }

            if (!is_array($eventData)) {
                $eventData = [];
            }

            $requiredEventdata = TripEventEnum::from($eventType)->requiredDataField();
            $validator = Validator::make($eventData, array_combine($requiredEventdata, array_fill(0, count($requiredEventdata), 'required')));
            if ($validator->fails()) {
                throw new ApiValidationException($validator);
            }

            $trip->events()->create([
                'type' => $eventType,
                'timestamp' => $timestamp,
                'data' => $eventData,
            ]);
        }

        return new ApiEloquentSucessResponse($trip);
    }

    public function createDataEntry(Request $request, string $id): ApiEloquentSucessResponse
    {
        // Retrieve the trip
        $trip = $this->getTrip($request, $id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required|array|size:5',
            'data.*.*' => 'required',
            'data.*.0' => 'required|numeric',
            'data.*.1' => 'required|numeric',
            'data.*.2' => 'required|array|size:3',
            'data.*.3' => 'required|array|size:3',
            'data.*.4' => 'numeric',
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator);
        }

        // Extract and validate the 'data' field
        $dataEntries = $request->get('data');

        // Create data entries for the trip
        foreach ($dataEntries as $dataEntry) {
            list($timestamp, $speed, $accelero, $gyroscope, $speed_limit) = $dataEntry;

            $trip->data()->create([
                'timestamp' => $timestamp,
                'speed' => $speed,
                'accelero' => $accelero,
                'gyroscope' => $gyroscope,
                'speed_limit' => $speed_limit,
            ]);
        }


        return new ApiEloquentSucessResponse($trip);
    }

    private function getTrip(Request $request, string $id): Trip
    {
        $trip = Trip::find($id);
        if (!$trip) {
            throw new TripNotFoundExecption();
        }

        $user = $request->get('user');
        if (!$trip->hasAccess($user)) {
            throw new NoAccessException();
        }

        return $trip;
    }
}
