<?php

use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/hello', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});

Route::get('/recipes', [RecipesController::class, 'getAll'])
    ->name('recipes.getAll');
