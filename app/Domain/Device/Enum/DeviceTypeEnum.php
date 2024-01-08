<?php

namespace App\Domain\Device\Enum;

enum DeviceTypeEnum: string
{
    case SIMULATOR = 'sim';
    case COMMA3X = 'comma';

    public function getLabel(): string
    {
        return match ($this) {
            self::SIMULATOR => 'Simulator',
            self::COMMA3X => 'Comma 3x',
        };
    }
}
