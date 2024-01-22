<?php

namespace App\Domain\Trip\Jobs;

use App\Domain\Trip\Helper\Parsers\TripProfileParser;
use App\Domain\Trip\Model\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostTripJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    public Trip $trip;
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }


    public function handle()
    {
        $this->processTrip($this->trip);

        $this->processProfiles($this->trip);

        $this->processEvents($this->trip);
    }

    private function processTrip(Trip $trip): void
    {
        $duration = $this->getDuration($trip);
        $avrageSpeed = $this->getAverageSpeed($trip);

        $distance = $duration * $avrageSpeed / 3600;
        $trip->update([
            'distance' => $distance
        ]);
    }

    private function getAverageSpeed(Trip $trip): float
    {
        return $trip->data()->get()->avg('speed');
    }

    private function getDuration(Trip $trip): int
    {
        return $trip->end_time->diffInSeconds($trip->start_time);
    }

    private function processProfiles(Trip $trip): void
    {
        $parsers = TripProfileParser::getParsers($trip);
        foreach ($parsers as $parser) {
            $parser->parse($trip);
        }
    }

    private function processEvents(Trip $trip): void
    {
        $duration = $this->getDuration($trip); // total duration in seconds
        $averageSpeed = $this->getAverageSpeed($trip); // average speed

        $totalDistance = $duration * $averageSpeed / 3600; // total distance in kilometers

        $events = $trip->events()->get();
        foreach ($events as $event) {
            $timestamp = $event->timestamp;

            $timeDiff = $timestamp->diffInSeconds($trip->start_time);

            $eventDistance = $timeDiff * $averageSpeed / 3600; // in kilometers

            $percentageOfTrip = ($eventDistance / $totalDistance) * 100;
            if ($percentageOfTrip > 100) {
                $percentageOfTrip = 100;
            }

            $event->update([
                'distance' => $percentageOfTrip,
                'distance_in_km' => $eventDistance,
            ]);
        }
    }
}
