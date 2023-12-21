<?php

namespace App\Helpers\Graph\Enums;

enum AxisFormat: string
{
    case LINEAR = 'linear';
    case LOGARITHMIC = 'logarithmic';
    case CATEGORY = 'category';
    case TIME = 'time';
    // Voeg meer asformaten toe indien nodig
}
