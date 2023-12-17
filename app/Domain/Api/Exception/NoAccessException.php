<?php

namespace App\Domain\Api\Exception;

class NoAccessException extends ApiException
{
    protected function getDefaultMessage(): string
    {
        return "No access to this resource";
    }

    protected function getDefaultCode(): int
    {
        return 403;
    }
}
