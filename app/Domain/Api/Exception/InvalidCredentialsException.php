<?php

namespace App\Domain\Api\Exception;

use Throwable;

class InvalidCredentialsException extends ApiException
{
    protected function getDefaultMessage(): string
    {
        return "Invalid credentials";
    }

    protected function getDefaultCode(): int
    {
        return 401;
    }
}
