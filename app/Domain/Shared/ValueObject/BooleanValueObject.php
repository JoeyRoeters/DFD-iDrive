<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Abstract\AbstractValueObject;
use App\Domain\Shared\Exception\InvalidArgumentException;

class BooleanValueObject extends AbstractValueObject
{
    public static function fromString(string $value): static
    {
        if ('true' === $value) {
            return new static(true);
        }

        if ('false' === $value) {
            return new static(false);
        }

        throw new InvalidArgumentException('Invalid boolean value');
    }

    public function __toString(): string
    {
        return $this->value() ? 'true' : 'false';
    }

    public function isTrue(): bool
    {
        return true === $this->value;
    }

    public function isFalse(): bool
    {
        return false === $this->value;
    }
}
