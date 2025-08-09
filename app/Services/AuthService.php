<?php

namespace App\Services;

use App\DTO\Responses\BaseResponse;
use App\DTO\Requests\LoginRequest;
use App\DTO\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    protected UserRepo $_userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->_userRepo = $userRepo;
    }

    public function login(LoginRequest $request): array
    {
        $email = $request->getEmail();
        $password = $request->getPassword();

        $user = $this->_userRepo->findUserByEmail($email);

        if (!$user) {
            return [new BaseResponse(false, 'User not found', 404), null];
        }

        if (!password_verify($password, $user->password)) {
            return [new BaseResponse(false, 'Incorrect Password', 401), null];
        }

        $tokens = $this->generateTokens($user);

        $res = new BaseResponse(true, 'Login successful', 200, $user);

        return [$res, $tokens];
    }

    public function register(RegisterRequest $request): array {
        // TO-DO: Validate Credentials

        $newUser = $this->_userRepo->createUser([
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
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
            'exp' => time() + (60 * 60)
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

        return JWT::encode($payload, $secret, env('JWT_ALGORITHM'));
    }

    // TO-DO: fill up the placeholders

    public function refresh(): bool {
        return true;
    }

    public function logout(): bool {
        return true;
    }
}
