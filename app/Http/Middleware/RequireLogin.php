<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequireLogin
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Checking authentication for: '.$request->fullUrl());

        if (! Auth::check()) {
            if ($request->expectsJson()) {
                $request->session()->flash('toastMessage', 'You need to log in to perform this action.');
                $request->session()->flash('toastType', 'error');

                return response()->json([
                    'success' => false,
                    'status_code' => 401,
                    'message' => 'You need to log in to perform this action.',
                ], 401);
            }

            $request->session()->flash('toastMessage', 'You need to log in to perform this action.');
            $request->session()->flash('toastType', 'error');

            Log::info('Unauthorized access attempt to: '.$request->fullUrl());

            return redirect()->route('auth.login.show');
        }

        return $next($request);
    }
}
