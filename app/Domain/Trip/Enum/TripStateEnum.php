<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Trait\EnumToArray;

enum TripStateEnum: String
{
    use EnumToArray;

    case IN_PROGRESS = 'in_progress';
    case FINISHED = 'finished';
    case CANCELLED = 'cancelled';

    public function getTranslation(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'In Progress',
            self::FINISHED => 'Finished',
            self::CANCELLED => 'Cancelled / Stopped',
        };
    }
}
