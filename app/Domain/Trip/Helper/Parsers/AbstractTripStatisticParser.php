<?php

namespace App\Domain\Trip\Helper\Parsers;

use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripStatistic;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractTripStatisticParser
{
    private Collection $tripStatistics;

    public function __construct(
        private Trip $trip,
    ) {
        $this->tripStatistics = $this->trip->statistics()->get();
    }

    public function getTrip(): Trip
    {
        return $this->trip;
    }

    public function getTripStatistics(): Collection
    {
        return $this->tripStatistics;
    }

    protected function getTripStatistic(TripStatisticParserEnum $parser): ?TripStatistic
    {
        return $this->tripStatistics->where('parser', $parser)->first();
    }
}
