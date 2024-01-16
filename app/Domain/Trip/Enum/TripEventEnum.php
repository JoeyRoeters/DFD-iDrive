<?php

namespace App\Domain\Trip\Enum;

use App\Domain\Shared\Enum\SeverityEnum;
use App\Domain\Shared\Trait\EnumToArray;

enum TripEventEnum: String
{
    use EnumToArray;

    case CROSSED_LINE = 'crossed_line';
    case COLLISION = 'collision';
    case SPEEDING = 'speeding';
    case TOO_SLOW = 'too_slow';
    case HARSH_BRAKING = 'harsh braking';
    case BREAKING_AND_GAS = 'breaking_and_gas';
    case MISSED_GEAR = 'missed_gear';
    case LATE_SHIFT_GEAR = 'late_shift_gear';
    case MISSED_SHIFT_GEAR = 'missed_shift_gear';
    case HARSH_STEERING = 'harsh_steering';
    case INEFFICIENT_STEERING = 'inefficient_steering';

    public function requiredDataField(): array
    {
        return match($this) {
            self::SPEEDING => ['speed', 'speed_limit'],
            default => [],
        };
    }

    public function getEventTitle(mixed $value = null): string
    {
        return match ($this) {
            self::CROSSED_LINE => 'Lane departure detected',
            self::COLLISION => 'Collision detected',
            self::SPEEDING => $this->getSpeedingEventTitle($value),
            self::HARSH_BRAKING => 'Abrupt Braking Occurrence',
            self::BREAKING_AND_GAS => 'Incorrect Throttle and Brake usage',
            self::LATE_SHIFT_GEAR => 'Delayed Gear engagement',
            self::MISSED_SHIFT_GEAR => 'Gear Shift Omitted',
            self::MISSED_GEAR => 'Gear Engagement Omitted',
            self::HARSH_STEERING => 'Aggressive Steering Maneuver',
            self::INEFFICIENT_STEERING => 'Suboptimal Steering Maneuver',

            default => throw new \Exception('Unexpected match value'),
        };
    }

    private function getSpeedingEventTitle(mixed $value): string
    {
        $value = $value['speed'] - $value['speed_limit'];

        $value = round($value);

        return 'Over the speed limit +' . $value . ' km/h';
    }

    public function getEventSubtitle(mixed $value = null): ?string
    {
        return match ($this) {
            self::SPEEDING => $this->getSpeedingEventSubtitle($value),
            default => null
        };
    }

    private function getSpeedingEventSubtitle(mixed $value): string
    {
        $value = $value['speed_limit'];

        return 'Speed limit: ' . $value . ' km/h';
    }

    public function getEventSeverity(mixed $value = null): SeverityEnum
    {
        return match ($this) {
            self::CROSSED_LINE => SeverityEnum::MEDIUM,
            self::COLLISION => SeverityEnum::HIGH,
            self::SPEEDING => $this->getSpeedSeverity($value),
            self::HARSH_BRAKING => SeverityEnum::MEDIUM,
            self::BREAKING_AND_GAS => SeverityEnum::HIGH,
            self::LATE_SHIFT_GEAR => SeverityEnum::MEDIUM,
            self::MISSED_SHIFT_GEAR => SeverityEnum::MEDIUM,
            self::MISSED_GEAR => SeverityEnum::MEDIUM,
            self::HARSH_STEERING => SeverityEnum::MEDIUM,
            self::INEFFICIENT_STEERING => SeverityEnum::MEDIUM,
            default => throw new \Exception('Unexpected match value'),
        };
    }

    private function getSpeedSeverity(mixed $value): SeverityEnum
    {
        if (!is_array($value) && is_string($value)) {
            $value = json_decode($value, true);
        }

        $value = $value['speed'] - $value['speed_limit'];

        return match (true) {
            $value > 0 && $value <= 10 => SeverityEnum::MEDIUM,
            $value > 10 && $value <= 20 => SeverityEnum::MEDIUM,
            $value > 20 => SeverityEnum::HIGH,
            $value < 0 => SeverityEnum::LOW,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
