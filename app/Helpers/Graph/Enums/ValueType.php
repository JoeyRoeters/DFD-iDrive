<?php

namespace App\Helpers\Graph\Enums;

enum ValueType: string
{
    case NUMBER = 'number';
    case DATE = 'date';
    case STRING = 'string';
    // Voeg meer waarde typen toe indien nodig
}
