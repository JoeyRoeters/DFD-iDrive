<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Abstract\AbstractValueObject;

class StringValueObject extends AbstractValueObject
{
    public function __toString(): string
    {
        return $this->value();
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }
}
