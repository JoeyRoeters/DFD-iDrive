<?php

namespace App\Domain\Trip\Helper\Parsers\Profile;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;

class BreakingProfileParser extends AbstractProfileParser
{
    protected function getParserEnum(): TripStatisticParserEnum
    {
        return TripStatisticParserEnum::BREAK_PROFILE;
    }

    protected function getProfileTitle(): string
    {
        return 'Breaking';
    }

    protected function getProfileStatistics(): array
    {
        return [
            new ProfileStatisticValueObject(
                title: 'Abrupt Braking',
                value: $this->countEvents(TripEventEnum::HARSH_BRAKING)
            ),
            new ProfileStatisticValueObject(
                title: 'Incorrect paddle usage',
                value: $this->countEvents(TripEventEnum::BREAKING_AND_GAS)
            ),
        ];
    }

    public function parse(Trip $trip): void
    {
    }
}
