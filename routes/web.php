<?php

use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/recipes', [RecipesController::class, 'index'])->name('recipes.index');

Route::get('/recipes/{id}', [RecipesController::class, 'show'])->name('recipes.show');

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