<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    private readonly AuthService $_authService;

    public function __construct(AuthService $authService)
    {
        $this->_authService = $authService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $accessToken = $request->cookie('access_token');
            $refreshToken = $request->cookie('refresh_token');

            if (!$accessToken) {
                if ($refreshToken) {
                    $res = $this->_authService->refresh($refreshToken);

                    if ($res) {
                        $tokens = $res->getData();
                        $accessToken = $tokens['access_token'];
                        $refreshToken = $tokens['refresh_token'];

                        $response = $next($request);
                        $response->cookie('access_token', $accessToken, 15, '/', null, false, false)
                                 ->cookie('refresh_token', $refreshToken, 10080, '/', null, false, true);

                        Auth::guard()->setUser($this->_authService->getUserFromToken($accessToken));

                        return $response;
                    }
                }

                return $next($request);
            }

            Auth::guard()->setUser($this->_authService->getUserFromToken($accessToken));
            return $next($request);
        } catch (\Exception $e) {
            Log::error('JWT Authentication failed', [
                'error' => $e->getMessage(),
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
