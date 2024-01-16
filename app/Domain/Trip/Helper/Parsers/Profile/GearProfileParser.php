<?php

namespace App\Domain\Trip\Helper\Parsers\Profile;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;

class GearProfileParser extends AbstractProfileParser
{

    protected function getParserEnum(): TripStatisticParserEnum
    {
        return TripStatisticParserEnum::GEAR_PROFILE;
    }

    protected function getProfileTitle(): string
    {
        return 'Gear';
    }

    protected function getProfileStatistics(): array
    {
        return [
            new ProfileStatisticValueObject(
                title: 'Engagement Omitted',
                value: $this->countEvents(TripEventEnum::MISSED_GEAR)
            ),
            new ProfileStatisticValueObject(
                title: 'Late Shift',
                value: $this->countEvents(TripEventEnum::LATE_SHIFT_GEAR)
            )
        ];
    }

    public function parse(Trip $trip): void
    {
    }
}
