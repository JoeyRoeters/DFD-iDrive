<?php

namespace App\Domain\Shared\Interface;

interface ValueObjectInterface
{
    public function __toString(): string;

    public static function fromString(string $value): self;

    public function value(): mixed;

    public function equals(ValueObjectInterface $valueObject): bool;

    public function isEmpty(): bool;
}
