<?php

use App\Http\Middleware\GetUserOrPass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->name('users.')->group(function () {
    Route::prefix('users')->group(function () {
        // other users routes apart from .show
    });

    Route::get('/{username}', function ($username) {
        $profileUser = User::where('username', $username)->first();
        
        if (!$profileUser) {
            abort(404, 'User not found');
        }
        
        return view('users.show', [
            'user' => Auth::user(),
            'profileUser' => $profileUser,
        ]);
    })->name('show');
});