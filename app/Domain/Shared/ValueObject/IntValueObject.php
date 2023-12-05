<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Abstract\AbstractValueObject;

class IntValueObject extends AbstractValueObject
{
    public static function fromString(string $value): static
    {
        return new self((int) $value);
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

    public function isOdd(): bool
    {
        return 1 === $this->value() % 2;
    }

    public function isEven(): bool
    {
        return 0 === $this->value() % 2;
    }
}
