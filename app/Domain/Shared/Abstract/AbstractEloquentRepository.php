<?php

namespace App\Domain\Shared\Abstract;

use App\Domain\Shared\Interface\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentRepository implements EloquentRepositoryInterface
{
    /**
     * @param array<mixed> $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->getModel()::create($attributes);
    }

    abstract protected function getModel(): string;

    /**
     * @param mixed $id
     * @return Model|null
     */
    public function find(mixed $id): ?Model
    {
        return $this->getModel()::find($id);
    }
}
