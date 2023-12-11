<?php

namespace App\Helpers\Overview\Column\Enum;

enum ActionButtonEnum
{
    case ARROW;
    case BUTTON;

    public function value(): string
    {
        return match ($this) {
            self::ARROW => 'arrow',
            self::BUTTON => 'button',
        };
    }
}
