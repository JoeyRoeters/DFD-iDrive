<?php

namespace App\Domain\User\Repository;

use App\Domain\Shared\Abstract\AbstractEloquentRepository;
use App\Domain\User\Interface\UserRepositoryInterface;
use App\Domain\User\Model\User;

class UserRepository extends AbstractEloquentRepository implements UserRepositoryInterface
{
    protected function getModel(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getModel()::where('email', $email)->first();
    }
}
