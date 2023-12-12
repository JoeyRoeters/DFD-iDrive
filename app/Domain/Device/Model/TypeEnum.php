<?php

namespace App\Domain\Device\Model;

use Illuminate\Validation\Rules\Enum;

/**
 * @method static getValue($value)
 * @method static getDescription($value)
 */
class TypeEnum extends Enum
{
    const SIM = 'sim';
    const COMMA = 'comma';

}
