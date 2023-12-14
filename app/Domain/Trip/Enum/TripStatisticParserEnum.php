<?php

namespace App\Domain\Trip\Enum;

enum TripStatisticParserEnum
{
    case SPEED_PROFILE;
    case BREAK_PROFILE;
    case ACCELERATION_PROFILE;
    case STEERING_PROFILE;
    case GEAR_PROFILE;
}
