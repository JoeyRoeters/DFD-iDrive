<?php

namespace App\Helpers\Overview\Column\Enum;

enum RenderTypeEnum
{
    case TEXT;
    case INLINE_COLUMN_NAME_WITH_TEXT;
    case COLORED_NUMBER_0_100;
    case ACTION_BUTTON;
    case MULTI_ACTION_BUTTON;

    // custom render types
    case TRIP_LABEL;

    public function getType(): string
    {
        return match ($this) {
            self::TEXT => 'text',
            self::INLINE_COLUMN_NAME_WITH_TEXT => 'inline_column_name_with_text',
            self::COLORED_NUMBER_0_100 => 'colored_number_0_100',
            self::ACTION_BUTTON => 'action_button',
            self::TRIP_LABEL => 'trip_label',
            self::MULTI_ACTION_BUTTON => 'multi_action_button',
        };
    }
}
