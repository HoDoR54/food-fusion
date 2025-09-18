<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequirePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action, string $resource): Response
    {
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 401,
                    'message' => 'You need to log in to perform this action.',
                ], 401);
            }

            $request->session()->flash('toastMessage', 'You need to log in to perform this action.');
            $request->session()->flash('toastType', 'error');

            return redirect()->route('auth.login.show');
        }

        $user = Auth::user();

        if (! $user->hasPermission($action, $resource)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'You do not have permission to perform this action.',
                ], 403);
            }

            $request->session()->flash('toastMessage', 'You do not have permission to perform this action.');
            $request->session()->flash('toastType', 'error');

            return redirect()->route('home');
        }

        return $next($request);
    }
}
