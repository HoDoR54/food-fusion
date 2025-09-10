<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Enums\MasteryLevel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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

    public function login(LoginRequest $request)
    {
        $metadata = ['ip_address' => $request->ip(), 'decay_minutes' => 3];

        [$response, $tokens] = $this->_authService->login($request, $metadata);

        if (!$response->isSuccess()) {
            return back()->with([
                'toastMessage' => $response->getMessage(),
                'toastType' => 'error'
            ]);
        }

        session()->flash('toastMessage', 'Login successful!');
        session()->flash('toastType', 'success');
        return redirect('/')
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, false, true);
    }

    public function register(RegisterRequest $request)
    {
        [$response, $tokens] = $this->_authService->register($request);

        if (!$response->isSuccess()) {
            return back()->with([
                'toastMessage' => $response->getMessage(),
                'toastType' => 'error'
            ]);
        }

        session()->flash('toastMessage', 'Registration successful! Welcome to Food Fusion!');
        session()->flash('toastType', 'success');
        return redirect('/')
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, false, true);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookieNames = ['access_token', 'refresh_token'];
        foreach ($cookieNames as $cookieName) {
            if ($request->hasCookie($cookieName)) {
                $request->queue(
                    Cookie::forget($cookieName)
                );
            }
        }

        return redirect('/')->with([
            'toastMessage' => 'Logout successful!',
            'toastType' => 'success'
        ]);
    }
}
