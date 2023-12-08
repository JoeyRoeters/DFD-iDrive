<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Abstract\AbstractValueObject;
use App\Domain\Shared\Interface\ValueObjectInterface;

class FloatValueObject extends AbstractValueObject
{
    public const PRECISION = 10;

    public static function fromString(string $value): self
    {
        return new self((float) $value);
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function isPositive(): bool
    {
        return $this->value() > 0;
    }

    public function isNegative(): bool
    {
        return $this->value() < 0;
    }

    public function isZero(): bool
    {
        return 0 === $this->value();
    }

    public function equals(ValueObjectInterface $valueObject): bool
    {
        $epsilon = 1 / self::PRECISION;

        return abs($this->value() - $valueObject->value()) < $epsilon;
    }
}
