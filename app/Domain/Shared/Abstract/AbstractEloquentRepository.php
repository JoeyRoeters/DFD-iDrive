w<?php

namespace App\Domain\Shared\Abstract;

use App\Domain\Shared\Interface\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentRepository implements EloquentRepositoryInterface
{
    public function create(array $attributes): Model
    {
        return $this->getModel()::create($attributes);
    }

    abstract protected function getModel(): string;

    public function find($id): ?Model
    {
        return $this->getModel()::find($id);
    }
}
