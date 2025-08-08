<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\DTO\Requests\LoginRequest;
use App\DTO\Requests\RegisterRequest;
use App\Enums\MasteryLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    protected AuthService $_authService;

    public function __construct(AuthService $authService)
    {
        $this->_authService = $authService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loginRequest = new LoginRequest($credentials['email'], $credentials['password']);

        [$response, $tokens] = $this->_authService->login($loginRequest);

        if (!$response->toArray()['success']) {
            return response()->json($response->toArray(), $response->toArray()['status_code']);
        }

        return response()->json($response->toArray(), 200)
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, true, true);
    }

    public function register(Request $request)
    {
        $data = $request->only('firstName', 'lastName', 'email', 'phoneNumber', 'password');

        $registerRequest = new RegisterRequest(
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['phoneNumber'],
            $data['password'],
            MasteryLevel::BEGINNER
        );

        [$response, $tokens] = $this->_authService->register($registerRequest);

        if (!$response->toArray()['success']) {
            return response()->json($response->toArray(), $response->toArray()['status_code']);
        }

        return response()->json($response->toArray(), 201)
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, true, true);
    }

    public function logout(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');

        $this->_authService->logout($refreshToken);

        return response()->json(['message' => 'Logged out'])
            ->cookie('access_token', '', -1)
            ->cookie('refresh_token', '', -1);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');

        $result = $this->_authService->refresh($refreshToken);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 401);
        }

        return response()->json(['message' => 'Token refreshed'])
            ->cookie('access_token', $result['access_token'], 15, '/', null, false, false);
    }
}
