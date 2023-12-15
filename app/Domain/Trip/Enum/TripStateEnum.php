<?php

namespace App\Domain\Trip\Enum;

enum TripStateEnum
{
    case IN_PROGRESS;
    case FINISHED;
    case CANCELLED;

    public function getTranslation(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'In Progress',
            self::FINISHED => 'Finished',
            self::CANCELLED => 'Cancelled / Stopped',
        };
    }
}
