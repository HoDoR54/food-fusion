<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipesController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.index');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.index');

Route::middleware(Authenticate::class)->group(function () {
    // Landing Page
    Route::get('/', function () {
        return view('index');
    })->name('home')->middleware(Authenticate::class);

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

