<?php

namespace App\Domain\Trip\ValueObject\Statistic;

class ProfileStatisticValueObject
{
    public function __construct(
        private string $title,
        private string $value,
        private ?string $unit = null,
    )
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getValue(): string
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
