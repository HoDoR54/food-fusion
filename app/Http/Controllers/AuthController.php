<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\DTO\Requests\LoginRequest;
use App\DTO\Requests\RegisterRequest;
use App\Enums\MasteryLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

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
            return back()->withErrors(['email' => $response->toArray()['message']]);
        }

        // TO-DO: change refresh token 'secure' argument back to true
        return redirect('/')
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, false, true);
    }

    public function register(Request $request)
    {
        Log::info('Register method called', [
            'request_data' => $request->all(),
            'csrf_token' => $request->input('_token'),
            'session_token' => session()->token()
        ]);

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
            return back()->withErrors(['email' => $response->toArray()['message']]);
        }

        return redirect('/')
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, false, true);
    }

    public function logout(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');

        $this->_authService->logout($refreshToken);

        return response()->json(['message' => 'Logged out'])
            ->cookie('access_token', '', -1)
            ->cookie('refresh_token', '', -1);
    }
}
