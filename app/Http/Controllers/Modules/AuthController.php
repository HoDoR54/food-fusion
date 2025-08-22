<?php

namespace App\Http\Controllers\Modules;

use App\Services\AuthService;
use App\DTO\Requests\LoginRequest;
use App\DTO\Requests\RegisterRequest;
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

    public function login(Request $request)
    {
        $credentials = $request->only('identifier', 'password');
        $loginRequest = new LoginRequest($credentials['identifier'], $credentials['password']);
        $metadata = ['ip_address' => $request->ip(), 'decay_minutes' => 3];

        [$response, $tokens] = $this->_authService->login($loginRequest, $metadata);

        if (!$response->toArray()['success']) {
            return back()->with([
                'toastMessage' => $response->toArray()['message'],
                'toastType' => 'error'
            ]);
        }

        session()->flash('toastMessage', 'Login successful!');
        session()->flash('toastType', 'success');

        Log::info('User logged in successfully', [
            'ip_address' => $request->ip(),
            'tokens' => $tokens
        ]);


        return redirect('/')
            ->cookie('access_token', $tokens['access_token'], 15, '/', null, false, false)
            ->cookie('refresh_token', $tokens['refresh_token'], 10080, '/', null, false, true);
    }

   public function setSession(Request $request)
    {
        Log::info("Raw request data: " . $request->getContent());
        Log::info("Request all(): " . json_encode($request->all()));
        Log::info("Request input(): " . json_encode($request->input()));
        
        foreach ($request->all() as $key => $value) {
            Log::info("Setting session key: $key with value: $value");
            
            if ($key === 'isPopUpConsent' && $value === 'false') {
                session([$key => false]);
                Log::info("Converted string 'false' to boolean false for $key");
            } else {
                session([$key => $value]);
            }
        }

        return Response::json([
            'success' => true,
            'message' => 'Session updated successfully.',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->only('firstName', 'lastName', 'username', 'email', 'phoneNumber', 'password', 'mastery_level');

        $registerRequest = new RegisterRequest(
            $data['firstName'],
            $data['lastName'],
            $data['username'],
            $data['email'],
            $data['phoneNumber'],
            $data['password'],
            $data['mastery_level']
        );

        [$response, $tokens] = $this->_authService->register($registerRequest);

        if (!$response->toArray()['success']) {
            return back()->with([
                'toastMessage' => $response->toArray()['message'],
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
