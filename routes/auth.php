<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckFailedLoginAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::prefix('sessions')->group(function () {
    Route::post('/set', function (Request $request) {
        $key = $request->input('key');
        $value = $request->input('value');
        session([$key => $value]);
    });
    Route::get('/{key}/get', function ($key) {
        return response()->json([
            'value' => session($key),
        ]);
    });
});


