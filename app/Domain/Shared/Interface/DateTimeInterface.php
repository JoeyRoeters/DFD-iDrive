<?php

namespace App\Domain\Shared\Interface;

interface DateTimeInterface
{
    public const DATETIME_FORMAT = 'Y-m-d H:i:s.u e';
    public const DATETIME_ZONE = 'UTC';

    public function value(): string;

    public static function fromPrimitives(string $datetime): static;
}
