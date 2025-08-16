<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use App\DTO\Requests\LoginRequest;
use App\DTO\Requests\RegisterRequest;
use App\Models\FailedLoginAttempt;
use App\Models\User;
use App\Repositories\UserRepo;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected UserRepo $_userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->_userRepo = $userRepo;
    }

    public function addFailedLoginAttempt(string $ipAddress, int $decayMinutes): void
    {
        $this->_userRepo->addFailedLoginAttempt($ipAddress, $decayMinutes);
    }

    public function findRecentFailedLoginAttempt(string $ipAddress, int $decayMinutes): ?FailedLoginAttempt
    {
        return $this->_userRepo->findRecentFailedLoginAttempt($ipAddress, $decayMinutes);
    }

    public function login(LoginRequest $request, array $metadata): array
    {
        $identifier = $request->getIdentifier();
        $password = $request->getPassword();

        $user = $this->_userRepo->findUserByEmailOrUsername($identifier);

        if (!$user) {
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            Log::warning("Login attempt failed for identifier: $identifier");
            return [new BaseResponse(false, 'User not found', 404), null];
        }

        if (!password_verify($password, $user->password)) {
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            Log::warning("Login attempt failed with an incorrect password.");
            return [new BaseResponse(false, 'Incorrect Password', 401), null];
        }

        $tokens = $this->generateTokens($user);

        $res = new BaseResponse(true, 'Login successful', 200, $user);

        return [$res, $tokens];
    }

    public function register(RegisterRequest $request): array {
        // Validate Credentials
        $validationErrors = $this->validateRegistrationData($request);
        if (!empty($validationErrors)) {
            return [new BaseResponse(false, implode(', ', $validationErrors), 400), null];
        }

        $newUser = $this->_userRepo->createUser([
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
            'username' => $request->getUsername(),
            'email' => $request->getEmail(),
            'phone' => $request->getPhoneNumber(),
            'mastery_level' => $request->getMasteryLevel(),
            'password' => password_hash($request->getPassword(), PASSWORD_BCRYPT),
        ]);

        if (!$newUser) {
            return [new BaseResponse(false, 'Registration failed', 500), null];
        }

        $tokens = $this->generateTokens($newUser);

        return [new BaseResponse(true, 'Registration successful', 201, $newUser), $tokens];
    }

    private function validateRegistrationData(RegisterRequest $request): array
    {
        $errors = [];

        if (strlen($request->getUsername()) < 3) {
            $errors[] = 'Username must be at least 3 characters long';
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $request->getUsername())) {
            $errors[] = 'Username can only contain letters, numbers, and underscores';
        }

        if ($this->_userRepo->findUserByUsername($request->getUsername())) {
            $errors[] = 'Username is already taken';
        }

        if ($this->_userRepo->findUserByEmail($request->getEmail())) {
            $errors[] = 'Email is already registered';
        }

        if (strlen($request->getPassword()) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }

        return $errors;
    }

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

        $this->_userRepo->storeRefreshToken($user->id, $token);

        return $token;
    }

    public function refresh(string $refreshToken): BaseResponse {
        if ($this->isTokenExpired($refreshToken)) {
            return new BaseResponse(false, 'Refresh token expired', 401);
        }

        $user = $this->getUserFromToken($refreshToken);
        if (!$user) {
            return new BaseResponse(false, 'User not found', 404);
        }

        $newTokens = $this->generateTokens($user);

        return new BaseResponse(true, 'Token refreshed successfully', 200, $newTokens);
    }

    // TO-DO: fill up the placeholders
    public function logout(): bool {
        return true;
    }

    public function getUserFromToken(string $token): ?User
    {
        try {
            $secret = env('JWT_SECRET');
            $alg = env('JWT_ALGORITHM');
            $payload = JWT::decode($token, new Key($secret, $alg));
            return $this->_userRepo->findUserById($payload->sub);
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
}
