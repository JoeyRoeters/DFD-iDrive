<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Trait\EnumToArray;

enum TripEventTypeEnum: String
{
    use EnumToArray;

    case START = 'start';
    case STOP = 'stop';
}
