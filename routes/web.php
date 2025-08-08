<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('index');
})->name('home');

// Auth
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/auth/forgot-password', function () {
    return view('auth.ဘာတွေမျှော်လင့်');
})->name('auth.ဘာတွေမျှော်လင့်');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Recipes
Route::get('/recipes', [RecipesController::class, 'index'])->name('recipes.index');

Route::get('/recipes/{id}', [RecipesController::class, 'show'])->name('recipes.show');

// Static Pages

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

