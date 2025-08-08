<?php

namespace App\Repositories;

use App\Models\User;

class UserRepo extends AbstractRepo
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}