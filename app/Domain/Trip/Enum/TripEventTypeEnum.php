<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Trait\EnumToArray;

enum TripEventTypeEnum: String
{
    use EnumToArray;

    case START = 'System start';
    case STOP = 'stop';
    case CROSSED_LINE = 'crossed_line';
    case COLLISION = 'collision';
}
