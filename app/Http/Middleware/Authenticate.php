<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    private readonly UserRepo $_userRepo;

    public function __construct(UserRepo $userRepo) {
        $this->_userRepo = $userRepo;
    }

    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Authenticate middleware running for URL: ' . $request->url());
        $token = $request->cookie('access_token');
        // dd($token);
        Log::info('Access token from cookie:', ['token' => $token]);

        if (!$token) {
            return $next($request);
        }

        try {
            $secret = env('JWT_SECRET');
            $alg = env('JWT_ALGORITHM');
            $payload = JWT::decode($token, new Key($secret, $alg));
            
            Log::info('JWT decoded successfully', ['payload' => (array)$payload]);

            $user = $this->_userRepo->findUserById($payload->sub);
            if ($user) {
                Auth::guard()->setUser($user);
                Log::info('User authenticated', ['user_id' => $user->id, 'user_name' => $user->name]);
            } else {
                Log::warning('User not found', ['user_id' => $payload->sub]);
            }
        } catch (\Exception $e) {
            Log::error('JWT Authentication failed', [
                'error' => $e->getMessage(),
                'url' => $request->url()
            ]);
        }

        return $next($request);
    }
}
