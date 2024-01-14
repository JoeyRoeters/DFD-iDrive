<?php

namespace App\Domain\Trip\Enum;

enum TripStatisticParserEnum: String
{
    case SPEED_PROFILE = 'speed_profile';
    case BREAK_PROFILE = 'break_profile';
    case STEERING_PROFILE = 'steering_profile';
    case GEAR_PROFILE = 'gear_profile';

    public function getEventEnums(): array
    {
        return match ($this) {
            self::SPEED_PROFILE => [
                TripEventEnum::SPEEDING,
            ],
            self::BREAK_PROFILE => [
                TripEventEnum::HARSH_BRAKING,
                TripEventEnum::BREAKING_STOP_SHORT,
                TripEventEnum::PERFECECT_BREAK,
                TripEventEnum::INEFFICIENT_BREAK,
            ],
            self::STEERING_PROFILE => [
                TripEventEnum::HARSH_STEERING,
                TripEventEnum::INEFFICIENT_STEERING,
//                TripEventEnum::COLLISION,
            ],
            self::GEAR_PROFILE => [
                TripEventEnum::MISSED_GEAR,
                TripEventEnum::PERFECT_GEAR,
                TripEventEnum::INEFFICIENT_GEAR,
            ],
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
