<?php

namespace App\Repositories;

use App\Models\LoginAttempt;
use App\Models\RefreshToken;
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

    public function storeRefreshToken(string $userId, string $token): bool
    {
        RefreshToken::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        return RefreshToken::where('user_id', $userId)
            ->where('token', $token)
            ->exists();
    }

    public function findRecentLoginAttempt(string $ipAddress, int $decayMinutes): ?LoginAttempt
    {
        return LoginAttempt::where('ip_address', $ipAddress)
            ->where('last_attempted_at', '>=', now()->subMinutes($decayMinutes))
            ->first();
    }

    public function addFailedLoginAttempt(string $ipAddress, int $decayMinutes): void
    {
        $loginAttempt = $this->findRecentLoginAttempt($ipAddress, $decayMinutes);

        if ($loginAttempt) {
            $loginAttempt->increment('attempts_count');
            $loginAttempt->touch('last_attempted_at');
        } else {
            LoginAttempt::create([
                'ip_address' => $ipAddress,
                'last_attempted_at' => now(),
                'attempts_count' => 1,
            ]);
        }
    }

}