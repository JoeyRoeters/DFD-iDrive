<?php

namespace App\UserInterface\Domain\Shared\Responses;

use Illuminate\Http\JsonResponse;
use MongoDB\Laravel\Eloquent\Model;

class ApiEloquentSucessResponse extends JsonResponse
{
    public function __construct(Model $model)
    {
        $data = [
            'status' => 'success',
            'model' => $model->getTable(),
            'data' => $model->toArray()
        ];

        parent::__construct($data, 200);
    }
}
