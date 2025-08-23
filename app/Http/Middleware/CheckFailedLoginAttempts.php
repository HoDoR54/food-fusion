<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckFailedLoginAttempts
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
        $attempt = $this->_authService->findRecentFailedLoginAttempt($ipAddress, $this->decayMinutes);

        if ($attempt && $attempt->getAttemptsCount() >= $this->maxAttempts) {
            $maxSeconds = $this->decayMinutes * 60;
            $secondsPassed = $attempt->getLastAttemptedAt()->diffInSeconds(now());
            $secondsLeft = max(0, $maxSeconds - $secondsPassed);

            return back()->with([
                'toastMessage' => 'Too many login attempts. Please try again later after ' . floor($secondsLeft) . ' seconds.',
                'toastType' => 'warning'
            ]);
        }
        return $next($request);
    }
}
