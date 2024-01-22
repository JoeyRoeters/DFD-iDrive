<?php

namespace App\Domain\Trip\Helper\Parsers\Profile;

use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;

class SpeedProfileParser extends AbstractProfileParser
{
    protected int $averageSpeed = 0;

    protected function getParserEnum(): TripStatisticParserEnum
    {
        return TripStatisticParserEnum::SPEED_PROFILE;
    }

    protected function getProfileTitle(): string
    {
        return 'Speed';
    }

    protected function getProfileStatistics(): array
    {
        return [
            new ProfileStatisticValueObject(
                title: 'Average speed',
                value: $this->averageSpeed,
                unit: 'km/h'
            )
        ];
    }

    public function parse(Trip $trip): void
    {
        $statistic = $this->getTripStatistic(true);

        $statistic->data = [
            'averageSpeed' => $trip->data()->avg('speed'),
        ];

        $statistic->save();
    }

    public function getAverageSpeed(): int
    {
        return $this->averageSpeed;
    }

}
