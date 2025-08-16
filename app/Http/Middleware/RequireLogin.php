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
        if (!Auth::check()) {
            $request->session()->flash('toastMessage', 'You need to log in to perform this action.');
            $request->session()->flash('toastType', 'error');
            Log::info('Unauthorized access attempt to: ' . $request->fullUrl());
            return redirect()->route('auth.login.show');
        }

        return $next($request);
    }
}
