<?php

namespace App\Domain\Trip\Helper\Parsers;

use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Helper\Parsers\Profile\AbstractProfileParser;
use App\Domain\Trip\Helper\Parsers\Profile\BreakingProfileParser;
use App\Domain\Trip\Helper\Parsers\Profile\GearProfileParser;
use App\Domain\Trip\Helper\Parsers\Profile\SpeedProfileParser;
use App\Domain\Trip\Helper\Parsers\Profile\SteeringProfileParser;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileValueObject;

class TripProfileParser extends AbstractTripStatisticParser
{
    private SpeedProfileParser $speedProfileParser;
    private BreakingProfileParser $breakingProfileParser;
    private GearProfileParser $gearProfileParser;
    private SteeringProfileParser $steeringProfileParser;

    public function __construct(
        private Trip $trip,
    ) {
        parent::__construct($trip);

        $this->speedProfileParser = new SpeedProfileParser($trip);
        $this->breakingProfileParser = new BreakingProfileParser($trip);
        $this->gearProfileParser = new GearProfileParser($trip);
        $this->steeringProfileParser = new SteeringProfileParser($trip);
    }

    /**
     * @param Trip $trip
     * @return AbstractProfileParser[]
     */
    public static function getParsers(Trip $trip): array
    {
        $parser = new self($trip);

        return [
            $parser->getSpeedParser(),
            $parser->getBreakProfile(),
            $parser->getGearProfile(),
            $parser->getSteeringProfile()
        ];
    }

    public function getSpeedParser(): SpeedProfileParser
    {
        return $this->speedProfileParser;
    }

    public function getBreakProfile(): BreakingProfileParser
    {
        return $this->breakingProfileParser;
    }

    public function getGearProfile(): GearProfileParser
    {
        return $this->gearProfileParser;
    }

    public function getSteeringProfile(): SteeringProfileParser
    {
        return $this->steeringProfileParser;
    }
}
