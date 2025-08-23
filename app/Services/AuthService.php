<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        Log::info('AuthService: Processing login request', [
            'identifier' => $identifier,
            'identifier_length' => strlen($identifier),
            'password_length' => strlen($password),
            'ip_address' => $metadata['ip_address']
        ]);

        $user = $this->_userRepo->findUserByEmailOrUsername($identifier);

        if (!$user) {
            Log::warning('AuthService: User not found', [
                'identifier' => $identifier,
                'search_attempted' => 'email_or_username'
            ]);
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            Log::warning("Login attempt failed for identifier: $identifier");
            return [new BaseResponse(false, 'User not found', 404), null];
        }

        Log::info('AuthService: User found, verifying password', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_username' => $user->username
        ]);

        if (!password_verify($password, $user->password)) {
            Log::warning('AuthService: Password verification failed', [
                'user_id' => $user->id,
                'identifier' => $identifier
            ]);
            $this->addFailedLoginAttempt($metadata['ip_address'], $metadata['decay_minutes']);
            Log::warning("Login attempt failed with an incorrect password.");
            return [new BaseResponse(false, 'Incorrect Password', 401), null];
        }

        Log::info('AuthService: Password verified, generating tokens', [
            'user_id' => $user->id
        ]);

        $tokens = $this->generateTokens($user);

        Log::info('AuthService: Login successful, tokens generated', [
            'user_id' => $user->id,
            'access_token_length' => strlen($tokens['access_token']),
            'refresh_token_length' => strlen($tokens['refresh_token'])
        ]);

        $res = new BaseResponse(true, 'Login successful', 200, $user);

        return [$res, $tokens];
    }

    public function register(RegisterRequest $request): array {
        // Laravel Form Request validation is automatically handled
        // No need for manual validation since RegisterRequest already validates

        Log::info('AuthService: Processing registration request', [
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'mastery_level' => $request->input('mastery_level')
        ]);

        $userData = [
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phoneNumber'),
            'mastery_level' => $request->input('mastery_level'),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            'role_id' => $this->_userRepo->getDefaultRoleId(),
        ];

        Log::info('AuthService: Creating new user with data', [
            'userData_keys' => array_keys($userData),
            'username' => $userData['username'],
            'email' => $userData['email'],
            'role_id' => $userData['role_id']
        ]);

        $newUser = $this->_userRepo->createUser($userData);

        if (!$newUser) {
            Log::error('AuthService: User creation failed', [
                'email' => $request->input('email'),
                'username' => $request->input('username')
            ]);
            return [new BaseResponse(false, 'Registration failed', 500), null];
        }

        Log::info('AuthService: User created successfully, generating tokens', [
            'user_id' => $newUser->id,
            'username' => $newUser->username,
            'email' => $newUser->email
        ]);

        $tokens = $this->generateTokens($newUser);

        Log::info('AuthService: Registration successful, tokens generated', [
            'user_id' => $newUser->id,
            'access_token_length' => strlen($tokens['access_token']),
            'refresh_token_length' => strlen($tokens['refresh_token'])
        ]);

        return [new BaseResponse(true, 'Registration successful', 201, $newUser), $tokens];
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

        $this->_userRepo->revokeRefreshToken($user->id, $refreshToken);
        $newTokens = $this->generateTokens($user);

        return new BaseResponse(true, 'Token refreshed successfully', 200, $newTokens);
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
