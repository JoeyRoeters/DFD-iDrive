<?php

namespace App\Domain\Trip\Exception;

use App\Domain\Api\Exception\ApiException;

class TripNotFoundExecption extends ApiException
{

    protected function getDefaultMessage(): string
    {
        return 'Trip not found';
    }

    protected function getDefaultCode(): int
    {
        return 404;
    }
}
