<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginAttempts
{
    private readonly AuthService $_authService;
    private int $maxAttempts = 3;
    private int $decayMinutes = 3;

    public function __construct(AuthService $authService) {
        $this->_authService = $authService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        Log::info("IP: $ipAddress");

        $attempt = $this->_authService->findRecentLoginAttempt($ipAddress, $this->decayMinutes);
        Log::info("Login attempt: ", ['attempt' => $attempt]);

        if ($attempt && $attempt->getLoginAttemptsCount() >= $this->maxAttempts) {
        $maxSeconds = $this->decayMinutes * 60;
        $secondsPassed = $attempt->getLastAttemptedAt()->diffInSeconds(now());
        $secondsLeft = max(0, $maxSeconds - $secondsPassed);
        return response()->json([
            'message' => 'Too many login attempts. Please try again later.',
            'retry_after_seconds' => $secondsLeft
        ], 429);
    }

        return $next($request);
    }
}
