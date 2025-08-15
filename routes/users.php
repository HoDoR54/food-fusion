<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->name('users.')->group(function () {
    Route::prefix('users')->group(function () {
        // other users routes apart from .show
    });

    Route::get('/{username}', fn($username) => view('users.show', [
            'user' => Auth::user(),
        ]))->name('show');
});