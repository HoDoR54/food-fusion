<?php

use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/recipes', [RecipesController::class, 'index'])->name('recipes.index');

Route::get('/recipes/{id}', [RecipesController::class, 'show'])->name('recipes.show');