<?php

namespace App\Repositories;

use App\Models\User;

class UserRepo extends AbstractRepo
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findUserById(string $id): ?User
    {
        return $this->find($id);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->whereFirst(['email' => $email]);
    }

    public function createUser(array $data): ?User
    {
        return $this->create($data);
    }
}