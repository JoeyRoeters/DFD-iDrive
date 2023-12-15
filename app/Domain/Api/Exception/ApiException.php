<?php

namespace App\Domain\Api\Exception;

use Exception;
use Throwable;

abstract class ApiException extends Exception
{
    abstract protected function getDefaultMessage(): string;

    abstract protected function getDefaultCode(): int;

    public function handle()
    {
        $code = $this->getCode() ?: $this->getDefaultCode();
        $json = [
            'status' => 'error',
            'error' => [
                'code' => $code,
                'message' => $this->getMessage() ?: $this->getDefaultMessage()
            ]
        ];

        response()->json($json, $code)->send();

        exit;
    }
}
