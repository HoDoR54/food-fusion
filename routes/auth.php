<?php

use App\Http\Controllers\Modules\AuthController;
use App\Http\Middleware\CheckFailedLoginAttempts;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register.show');

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware(CheckFailedLoginAttempts::class)
        ->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::post('/set-session', [AuthController::class, 'setSession'])->name('auth.set-session');
