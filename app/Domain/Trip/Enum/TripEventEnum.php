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
    case HARSH_BRAKING = 'harsh braking';
    case BREAKING_STOP_SHORT = 'breaking_stop_short';
    case PERFECECT_BREAK = 'perfect_break';
    case INEFFICIENT_BREAK = 'inefficient_break';
    case MISSED_GEAR = 'missed_gear';
    case PERFECT_GEAR = 'perfect_gear';
    case INEFFICIENT_GEAR = 'inefficient_gear';
    case HARSH_STEERING = 'harsh_steering';
    case INEFFICIENT_STEERING = 'inefficient_steering';

    public function getEventTitle(mixed $value = null): string
    {
        return match ($this) {
            self::CROSSED_LINE => 'Crossed Line',
            self::COLLISION => 'Collision',
            self::SPEEDING => $this->getSpeedingEventTitle($value),
            self::HARSH_BRAKING => 'Harsh Braking',
            self::BREAKING_STOP_SHORT => 'Stop Short',
            self::PERFECECT_BREAK => 'Perfect Break',
            self::INEFFICIENT_BREAK => 'Inefficient Break',
            self::MISSED_GEAR => 'Missed Gear',
            self::PERFECT_GEAR => 'Perfect Gear',
            self::INEFFICIENT_GEAR => 'Inefficient Gear',
            self::HARSH_STEERING => 'Harsh Steering',
            self::INEFFICIENT_STEERING => 'Inefficient Steering',
            default => throw new \Exception('Unexpected match value'),
        };
    }

    private function getSpeedingEventTitle(mixed $value): string
    {
        $value = $value['speed'] - $value['speed_limit'];

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
            self::BREAKING_STOP_SHORT => SeverityEnum::HIGH,
            self::PERFECECT_BREAK => SeverityEnum::LOW,
            self::INEFFICIENT_BREAK => SeverityEnum::MEDIUM,
            self::MISSED_GEAR => SeverityEnum::MEDIUM,
            self::PERFECT_GEAR => SeverityEnum::LOW,
            self::INEFFICIENT_GEAR => SeverityEnum::MEDIUM,
            self::HARSH_STEERING => SeverityEnum::MEDIUM,
            self::INEFFICIENT_STEERING => SeverityEnum::MEDIUM,
            default => throw new \Exception('Unexpected match value'),
        };
    }

    private function getSpeedSeverity(mixed $value): SeverityEnum
    {
        $value = $value['speed'] - $value['speed_limit'];

        return match (true) {
            $value > 0 && $value <= 10 => SeverityEnum::LOW,
            $value > 10 && $value <= 20 => SeverityEnum::MEDIUM,
            $value > 20 => SeverityEnum::HIGH,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
