<?php

use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/ping', function () {
    return response()->json(['message' => 'pong']);
});

// API Routes with BaseResponse structure
Route::get('/recipes', [RecipesController::class, 'apiIndex']);
Route::get('/recipes/{id}', [RecipesController::class, 'apiShow']);
