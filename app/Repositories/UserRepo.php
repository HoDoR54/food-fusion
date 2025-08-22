<?php

namespace App\Repositories;

use App\Models\FailedLoginAttempt;
use App\Models\RefreshToken;
use App\Models\User;
use App\Models\Role;

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

    public function findUserByUsername(string $username): ?User
    {
        return $this->whereFirst(['username' => $username]);
    }

    public function findUserByEmailOrUsername(string $identifier): ?User
    {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($identifier);
        }
        
        return $this->findUserByUsername($identifier);
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

    public function findRecentFailedLoginAttempt(string $ipAddress, int $decayMinutes): ?FailedLoginAttempt
    {
        return FailedLoginAttempt::where('ip_address', $ipAddress)
            ->where('last_attempted_at', '>=', now()->subMinutes($decayMinutes))
            ->first();
    }

    public function addFailedLoginAttempt(string $ipAddress, int $decayMinutes): void
    {
        $failedLoginAttempt = $this->findRecentFailedLoginAttempt($ipAddress, $decayMinutes);

        if ($failedLoginAttempt) {
            $failedLoginAttempt->increment('attempts_count');
            $failedLoginAttempt->touch('last_attempted_at');
        } else {
            FailedLoginAttempt::create([
                'ip_address' => $ipAddress,
                'last_attempted_at' => now(),
                'attempts_count' => 1,
            ]);
        }
    }

    public function revokeRefreshToken(string $userId, string $token): bool
    {
        return RefreshToken::where('user_id', $userId)
            ->where('token', $token)
            ->update(['revoked' => true]);
    }

    public function getDefaultRoleId(): string
    {
        $userRoleId = Role::where('name', 'User')->value('id');
        return $userRoleId;
    }
}