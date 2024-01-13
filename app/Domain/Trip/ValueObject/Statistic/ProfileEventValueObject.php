<?php

namespace App\Domain\Trip\ValueObject\Statistic;

use App\Domain\Trip\Enum\TripEventEnum;

class ProfileEventValueObject
{
    public function __construct(
        private TripEventEnum $event,
        private int $distance,
        private mixed $value,
    )
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->event->getEventTitle($this->getValue());
    }

    public function getSubtitle(): string
    {
        return $this->event->getEventSubtitle($this->getValue());
    }

    public function getSeverity(): string
    {
        return $this->event->getEventSeverity()->value;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @return mixed
     */
    private function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }
}
