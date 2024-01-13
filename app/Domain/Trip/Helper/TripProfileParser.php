<?php

namespace App\Domain\Trip\Helper;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripStatistic;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileValueObject;

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
            events: [
                new ProfileEventValueObject(
                    event: TripEventEnum::START,
                    distance: 0,
                    value: 0,
                ),
            ]
        );
    }

    public function getBreakProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Break',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Average',
                    value: 0,
                    unit: 'km/h',
                ),
            ],
            events: [
                new ProfileEventValueObject(
                    event: TripEventEnum::START,
                    distance: 0,
                    value: 0,
                ),
            ]
        );
    }

    public function getGearProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Gear',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Average',
                    value: 0,
                    unit: 'km/h',
                ),
            ],
            events: [
                new ProfileEventValueObject(
                    event: TripEventEnum::START,
                    distance: 0,
                    value: 0,
                ),
            ]
        );
    }

    public function getSteeringProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: 'Steering',
            statistics: [
                new ProfileStatisticValueObject(
                    title: 'Average',
                    value: 0,
                    unit: 'km/h',
                ),
            ],
            events: [
                new ProfileEventValueObject(
                    event: TripEventEnum::START,
                    distance: 0,
                    value: 0,
                ),
            ]
        );
    }
}
