<?php

namespace App\UserInterface\Domain\Shared\Responses;

use Illuminate\Http\JsonResponse;

class ApiSucessResponse extends JsonResponse
{
    public function __construct($data = null)
    {
        $data = [
            'status' => 'success',
            'data' => $data
        ];

        parent::__construct($data, 200);
    }
}
