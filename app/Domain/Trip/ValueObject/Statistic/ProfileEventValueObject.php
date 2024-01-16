<?php

namespace App\Domain\Trip\ValueObject\Statistic;

use App\Domain\Trip\Enum\TripEventEnum;

class ProfileEventValueObject
{
    public function __construct(
        private TripEventEnum $event,
        private int $distance,
        private mixed $value,
    ) {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->event->getEventTitle($this->getValue());
    }

    public function getSubtitle(): ?string
    {
        return $this->event->getEventSubtitle($this->getValue());
    }

    public function hasSubtitle(): bool
    {
        return $this->getSubtitle() !== null;
    }

    public function getSeverity(): string
    {
        return $this->event->getEventSeverity($this->getValue())->value;
    }

    public function getSeverityLevel(): int
    {
        return $this->event->getEventSeverity($this->getValue())->getSeverityLevel();
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        // make sure the distance is between 5 and 95 and not 45 - 55; so they do not overlap with the % blocks of timeline
        $distance = $this->distance;
        if ($distance > 95) {
            return 95;
        }

        if ($distance < 5) {
            return 5;
        }

        if ($distance > 45 && $distance < 50) {
            return 43;
        }

        if ($distance >= 50 && $distance < 55) {
            return 57;
        }

        return $distance;
    }

    /**
     * @param int $distance
     * @return ProfileEventValueObject
     */
    public function setDistance(int $distance): ProfileEventValueObject
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getValue(): mixed
    {
        return $this->value;
    }
}
