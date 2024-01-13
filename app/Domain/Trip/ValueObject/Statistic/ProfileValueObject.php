<?php

namespace App\Domain\Trip\ValueObject\Statistic;

use App\Domain\Trip\Enum\TripStatisticParserEnum;

class ProfileValueObject
{
    /**
     * @param string $title
     * @param ProfileStatisticValueObject[] $statistics
     * @param TripStatisticParserEnum $parser
     */
    public function __construct(
        private string $title,
        private array $statistics,
        private array $events = [],
    ) {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return ProfileStatisticValueObject[]
     */
    public function getStatistics(): array
    {
        return $this->statistics;
    }

    /**
     * @return TripStatisticParserEnum
     */
    public function getParser(): TripStatisticParserEnum
    {
        return $this->parser;
    }
}
