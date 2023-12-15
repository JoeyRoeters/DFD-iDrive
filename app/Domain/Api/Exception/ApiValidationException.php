<?php

namespace App\Domain\Api\Exception;

use Illuminate\Validation\Validator;

class ApiValidationException extends ApiException
{
    public function __construct(protected Validator $validator)
    {
        $this->appendMessageData($this->validator->errors()->toArray());

        parent::__construct();
    }

    protected function getDefaultMessage(): string
    {
        return 'Validation error';
    }

    protected function getDefaultCode(): int
    {
        return 422;
    }
}
