<?php

namespace App\Domain\Trip\ValueObject\Statistic;

class ProfileStatisticValueObject
{
    public function __construct(
        private string $title,
        private int $value,
        private ?string $unit = null,
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
     * @return string
     */
    public function getValue(): string
    {
        $value = $this->value;
        if ($value < 10 && $this->unit !== 'km/h') {
            $value = '0' . $value;
        } elseif ($value < 100 && $this->unit === 'km/h') {
            if ($value < 10) {
                $value = '0' . $value;
            }

            $value = '0' . $value;
        }

        return $value;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }
}
