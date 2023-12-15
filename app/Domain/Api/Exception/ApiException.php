<?php

namespace App\Domain\Api\Exception;

use Exception;
use Throwable;

abstract class ApiException extends Exception
{
    private array $messageData = [];

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

        if (!empty($this->messageData)) {
            $json['error']['data'] = $this->messageData;
        }

        response()->json($json, $code)->send();

        exit;
    }

    protected function appendMessageData(array $data): self
    {
        $this->messageData = $data;

        return $this;
    }
}
