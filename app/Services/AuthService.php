<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\FailedLoginAttempt;
use App\Models\User;
use App\Models\Role;
use App\Models\RefreshToken;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class AuthService
{
    // Main Methods
    public function login(LoginRequest $request, array $metadata): array
    {
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        $user = User::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        if (!$user) {
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            return [new BaseResponse(false, 'User not found', 404), null];
        }

        if (!password_verify($password, $user->password)) {
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            return [new BaseResponse(false, 'Incorrect Password', 401), null];
        }
        $tokens = $this->generateTokens($user);

        $res = new BaseResponse(true, 'Login successful', 200, $user);

        return [$res, $tokens];
    }

    public function register(RegisterRequest $request): array {
        $userData = [
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phoneNumber'),
            'mastery_level' => $request->input('mastery_level'),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            'role_id' => $this->getDefaultRoleId(),
        ];
        $newUser = User::create($userData);

        if (!$newUser) {
            return [new BaseResponse(false, 'Registration failed', 500), null];
        }

        $tokens = $this->generateTokens($newUser);

        return [new BaseResponse(true, 'Registration successful', 201, $newUser), $tokens];
    }

    public function refresh(string $refreshToken): BaseResponse {
        if ($this->isTokenExpired($refreshToken)) {
            return new BaseResponse(false, 'Refresh token expired', 401);
        }

        $user = $this->getUserFromToken($refreshToken);
        if (!$user) {
            return new BaseResponse(false, 'User not found', 404);
        }

        $this->revokeRefreshToken($user->id, $refreshToken);
        $newTokens = $this->generateTokens($user);

        return new BaseResponse(true, 'Token refreshed successfully', 200, $newTokens);
    }

    // Token Management Methods
    public function getUserFromToken(string $token): ?User
    {
        try {
            $secret = env('JWT_SECRET');
            $alg = env('JWT_ALGORITHM');
            $payload = JWT::decode($token, new Key($secret, $alg));
            return User::find($payload->sub);
        } catch (\Exception $e) {
            Log::error('Failed to get user from token', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function isTokenExpired(string $token): bool
    {
        try {
            $secret = env('JWT_SECRET');
            $alg = env('JWT_ALGORITHM');
            $payload = JWT::decode($token, new Key($secret, $alg));
            return $payload->exp < time();
        } catch (\Exception $e) {
            Log::error('Failed to decode token for expiry check', ['error' => $e->getMessage()]);
            return true;
        }
    }

    // Token Generation Methods
    public function generateTokens(User $user): array
    {
        $accessToken = $this->createAccessToken($user);
        $refreshToken = $this->createRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    public function createAccessToken(User $user): string
    {
        $secret = env('JWT_SECRET', 'default_secret_key');
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 15)
        ];

        return JWT::encode($payload, $secret, env('JWT_ALGORITHM'));
    }

    public function createRefreshToken(User $user): string
    {
        $secret = env('JWT_SECRET', 'default_secret_key');
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24 * 7)
        ];

        $token = JWT::encode($payload, $secret, env('JWT_ALGORITHM'));

        RefreshToken::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        return RefreshToken::where('user_id', $userId)
            ->where('token', $token)
            ->exists();
    }

    // Failed Login Attempt Methods
    public function addFailedLoginAttempt(string $ipAddress, int $decayMinutes): void
    {
        $mostRecentAttempt = $this->findRecentFailedLoginAttempt($ipAddress, $decayMinutes);
        if ($mostRecentAttempt) {
            $mostRecentAttempt->increment('attempt_count');
            $mostRecentAttempt->last_attempted_at->touch();
        } else {
             FailedLoginAttempt::create([
                'ip_address' => $ipAddress,
                'last_attempted_at' => now(),
                'attempts_count' => 1,
            ]);
        }
    }

    public function findRecentFailedLoginAttempt(string $ipAddress, int $decayMinutes): ?FailedLoginAttempt
    {
        return FailedLoginAttempt::where('ip_address', $ipAddress)
            ->where('last_attempted_at', '>=', now()->subMinutes($decayMinutes))
            ->first();
    }

    private function getDefaultRoleId(): string
    {
        return Role::where('name', 'User')->value('id');
    }

    private function revokeRefreshToken(string $userId, string $token): bool
    {
        return RefreshToken::where('user_id', $userId)
            ->where('token', $token)
            ->update(['revoked' => true]);
    }
}