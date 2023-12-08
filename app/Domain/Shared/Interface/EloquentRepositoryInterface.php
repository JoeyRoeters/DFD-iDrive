<?php

namespace App\Domain\Shared\Interface;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * @param array<mixed> $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param mixed $id
     * @return Model
     */
    public function find(mixed $id): ?Model;
}
