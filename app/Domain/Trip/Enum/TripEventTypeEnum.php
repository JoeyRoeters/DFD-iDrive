<?php

namespace App\Domain\Trip\Enum;

enum TripEventTypeEnum
{
    case START;
    case STOP;
    case PAUSE;
    case RESUME;
    case TURN;
    case ACCELERATION;
    case BREAK;
    case SPEED;
    case GEAR;
    case STEERING;
    case FUEL;
    case ENGINE;
    case BATTERY;
    case ODOMETER;
    case LOCATION;
    case UNKNOWN;
}
