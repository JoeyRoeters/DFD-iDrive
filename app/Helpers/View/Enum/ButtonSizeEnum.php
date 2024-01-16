<?php

namespace App\Helpers\View\Enum;

enum ButtonSizeEnum: string
{
    case SMALL = 'btn-sm';
    case MEDIUM = '';
    case LARGE = 'btn-lg';

    public function getValue(): string
    {
        return $this->value;
    }
}
