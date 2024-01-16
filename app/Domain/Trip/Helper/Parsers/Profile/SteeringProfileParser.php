<?php

namespace App\Domain\Trip\Helper\Parsers\Profile;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;

class SteeringProfileParser extends AbstractProfileParser
{
    protected function getParserEnum(): TripStatisticParserEnum
    {
        return TripStatisticParserEnum::STEERING_PROFILE;
    }

    protected function getProfileTitle(): string
    {
        return 'Stearing';
    }

    protected function getProfileStatistics(): array
    {
        return [
            new ProfileStatisticValueObject(
                title: 'Abrupt Steering',
                value: $this->countEvents(TripEventEnum::HARSH_STEERING)
            ),
            new ProfileStatisticValueObject(
                title: 'Inefficient Steering',
                value: $this->countEvents(TripEventEnum::INEFFICIENT_STEERING)
            ),
        ];
    }

    public function parse(Trip $trip): void
    {
    }
}
