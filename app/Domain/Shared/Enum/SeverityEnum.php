<?php

namespace App\Domain\Shared\Enum;

enum SeverityEnum: String
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function getSeverity(): string
    {
        return $this->value;
    }

    public function getSeverityLevel(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
