<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipesController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckLoginAttempts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {
    // TO-DO: switch to Laravel Throttle after turning in
    Route::post('/login', [AuthController::class, 'login'])->middleware(CheckLoginAttempts::class)->name('auth.login');

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.index');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.index');

Route::post('/set-session', [AuthController::class, 'setSession'])->name('auth.set-session');

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/', function () {
        if (!session()->has('isPopUpConsent')) {
            session(['isPopUpConsent' => true]);
        }
        
        return view('index');
    })->name('home');

    Route::prefix('recipes')->group(function () {
        Route::get('/', [RecipesController::class, 'index'])->name('recipes.index');

        Route::get('/{id}', [RecipesController::class, 'show'])->name('recipes.show');
    });

    Route::get('/me', function () {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    })->name('me');

    Route::get('/about', function () {
        return view('static.about');
    });

    Route::get('/contact', function () {
        return view('static.contact');
    });

    Route::get('/educational-resources', function () {
        return view('static.edu');
    });

    Route::get('/cookbook', function () {
        return view('cookbook-blogs.index');
    });

    Route::get('/cookbook/new-post', function () {
        return view('cookbook-blogs.create');
    });
});

