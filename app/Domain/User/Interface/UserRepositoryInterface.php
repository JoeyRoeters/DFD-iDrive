<?php

namespace App\Domain\User\Interface;

use App\Domain\Shared\Interface\EloquentRepositoryInterface;
use App\Domain\User\Model\User;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByEmail(string $email): ?User;
}
