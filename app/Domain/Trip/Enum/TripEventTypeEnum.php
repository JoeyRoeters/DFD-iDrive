<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Trait\EnumToArray;

enum TripEventTypeEnum: String
{
    use EnumToArray;

    case START = 'System Start';
    case STOP = 'System End';
    case CROSSED_LINE = 'crossed_line';
    case COLLISION = 'collision';
    case SPEEDING = 'speeding'
    case HARSH_BRAKING = 'harsh braking'
}
