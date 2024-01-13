<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Enum\SeverityEnum;
use App\Domain\Shared\Trait\EnumToArray;

enum TripEventEnum: String
{
    use EnumToArray;

    case START = 'System Start';
    case STOP = 'System End';
    case CROSSED_LINE = 'crossed_line';
    case COLLISION = 'collision';


    public function getEventTitle(mixed $value = null): string
    {
        return match ($this->value) {
            self::START => 'System Start',
            self::STOP => 'System End',
            self::CROSSED_LINE => 'Crossed Line',
            self::COLLISION => 'Collision',
            default => throw new \Exception('Unexpected match value'),
        };
    }

    public function getEventSubtitle(mixed $value = null): string
    {
        return match ($this->value) {
            self::START => 'System Start',
            self::STOP => 'System End',
            self::CROSSED_LINE => 'Crossed Line',
            self::COLLISION => 'Collision',
            default => throw new \Exception('Unexpected match value'),
        };
    }

    public function getEventSeverity(mixed $value = null): SeverityEnum
    {
        return match ($this->value) {
            self::START => SeverityEnum::LOW,
            self::STOP => SeverityEnum::LOW,
            self::CROSSED_LINE => SeverityEnum::MEDIUM,
            self::COLLISION => SeverityEnum::HIGH,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
