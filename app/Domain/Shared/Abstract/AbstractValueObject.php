<?php

namespace App\Domain\Shared\Abstract;

use App\Domain\Shared\Interface\ValueObjectInterface;

abstract class AbstractValueObject implements ValueObjectInterface
{
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function equals(ValueObjectInterface $valueObject): bool
    {
        return $this->value() === $valueObject->value();
    }

    public function isEmpty(): bool
    {
        return empty($this->value());
    }
}
