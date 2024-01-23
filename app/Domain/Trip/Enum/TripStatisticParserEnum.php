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
                TripEventEnum::BREAKING_AND_GAS,
            ],
            self::STEERING_PROFILE => [
                TripEventEnum::HARSH_STEERING,
                TripEventEnum::INEFFICIENT_STEERING,
            ],
            self::GEAR_PROFILE => [
                TripEventEnum::MISSED_GEAR,
                TripEventEnum::LATE_SHIFT_GEAR,
                TripEventEnum::MISSED_SHIFT_GEAR
            ],
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
