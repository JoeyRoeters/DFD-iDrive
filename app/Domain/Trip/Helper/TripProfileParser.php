<?php

namespace App\Domain\Trip\Helper;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripEvent;
use App\Domain\Trip\Model\TripStatistic;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileValueObject;
use Illuminate\Database\Eloquent\Collection;

class TripProfileParser extends AbstractTripStatisticParser
{
    private ?TripStatistic $speedProfile;
    private ?TripStatistic $breakProfile;
    private ?TripStatistic $steeringProfile;
    private ?TripStatistic $gearProfile;

    public function __construct(
        private Trip $trip,
    ) {
        parent::__construct($trip);

        $this->speedProfile = $this->getTripStatistic(TripStatisticParserEnum::SPEED_PROFILE);
        $this->breakProfile = $this->getTripStatistic(TripStatisticParserEnum::BREAK_PROFILE);
        $this->steeringProfile = $this->getTripStatistic(TripStatisticParserEnum::STEERING_PROFILE);
        $this->gearProfile = $this->getTripStatistic(TripStatisticParserEnum::GEAR_PROFILE);
    }

    public static function getProfiles(Trip $trip): array
    {
        $parser = new self($trip);

        return [
            $parser->getSpeedProfile(),
            $parser->getBreakProfile(),
            $parser->getGearProfile(),
            $parser->getSteeringProfile()
        ];
    }

    public function getProfile(TripStatisticParserEnum $parser): ?ProfileValueObject
    {
        return match ($parser) {
            TripStatisticParserEnum::SPEED_PROFILE => $this->getSpeedProfile(),
            TripStatisticParserEnum::BREAK_PROFILE => $this->getBreakProfile(),
            TripStatisticParserEnum::STEERING_PROFILE => $this->getSteeringProfile(),
            TripStatisticParserEnum::GEAR_PROFILE => $this->getGearProfile(),
            default => null,
        };
    }

    private function getProfileEvent(TripStatisticParserEnum $profile): array
    {
        $events = $this->trip
            ->events()
            ->whereIn('type', $profile->getEventEnums())
            ->get();

        // build that it will retrieve TripEventValueObjects from processed stats
        foreach (TripEventEnum::values() as $event) {
            $event = TripEventEnum::from($event);
            if (!in_array($event, $profile->getEventEnums())) {
                continue;
            }

            for($i = 0; $i < rand(2, 5); $i++) {
                $events->push(new TripEvent([
                    'type' => $event,
                    'trip_id' => $this->trip->id,
                ]));
            }
        }

        $events = $events->map(function (TripEvent $event) {
            $value = null;
            if ($event->type === TripEventEnum::SPEEDING) {
                $speed = rand(20, 130);
                $limit = $speed - rand(5, 30);

                // round limit to 5
                $limit = round($limit / 5) * 5;

                $value = [
                    'speed' => $speed,
                    'speed_limit' => $limit
                ];
            }
            return new ProfileEventValueObject(
                event: $event->type,
                distance: rand(0, 100),
                value: $value,
            );
        })->toArray();

        $eventsOrdered = [];
        foreach ($events as $event) {
            $distance = $event->getDistance();
            if ($distance > 95) {
                $distance = 95;
            } elseif ($distance < 5) {
                $distance = 5;
            } elseif ($distance > 45 && $distance < 50) {
                $distance = 43;
            } elseif ($distance >= 50 && $distance < 55) {
                $distance = 57;
            }

            $event->setDistance($distance);

            $inRange = null;

            for($i = $distance - 7; $i < $distance + 15; $i++) {
                if (array_key_exists($i, $eventsOrdered)) {
                    $inRange = $eventsOrdered[$i];
                    break;
                }
            }

            if ($inRange instanceof ProfileEventValueObject) {
                if ($inRange->getSeverityLevel() > $event->getSeverityLevel()) {
                    continue;
                }

                unset($eventsOrdered[$inRange->getDistance()]);
            }

            $eventsOrdered[$distance] = $event;
        }

        return array_values($eventsOrdered);
    }

    public function getSpeedProfile(): ?ProfileValueObject
    {
        $averageSpeed = 0;

        return new ProfileValueObject(
            title: 'Speed',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Average',
                    value: 0,
                    unit: 'km/h',
                ),
            ],
            events: $this->getProfileEvent(TripStatisticParserEnum::SPEED_PROFILE)
        );
    }

    public function getBreakProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Break',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Stop short',
                    value: 12
                ),
                new ProfileStatisticValueObject(
                    title: 'Inefficient',
                    value: 7
                ),
                new ProfileStatisticValueObject(
                    title: 'Perfect',
                    value: 4
                ),
            ],
            events: $this->getProfileEvent(TripStatisticParserEnum::BREAK_PROFILE)
        );
    }

    public function getGearProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Gear',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Excpected Changes',
                    value: 1,
                ),
                new ProfileStatisticValueObject(
                    title: 'Changes',
                    value: 0,
                ),
            ],
            events: $this->getProfileEvent(TripStatisticParserEnum::GEAR_PROFILE)
        );
    }

    public function getSteeringProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Steering',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Wrong Steering',
                    value: 1
                ),
                new ProfileStatisticValueObject(
                    title: 'Inefficient',
                    value: 0
                ),

                new ProfileStatisticValueObject(
                    title: 'Efficient',
                    value: 0
                ),

            ],
            events: $this->getProfileEvent(TripStatisticParserEnum::STEERING_PROFILE)
        );
    }
}
