<?php

namespace App\Domain\Device\Model;

use Illuminate\Validation\Rules\Enum;

/**
 * @method static getValue($value)
 * @method static getDescription($value)
 */
class TypeEnum extends Enum
{
    public const SIM = 'sim';
    public const COMMA = 'comma';

}
