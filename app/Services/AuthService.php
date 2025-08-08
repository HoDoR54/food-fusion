<?php

namespace App\Services;

use App\Repositories\UserRepo;

class AuthService
{
    protected UserRepo $_userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->_userRepo = $userRepo;
    }
}
