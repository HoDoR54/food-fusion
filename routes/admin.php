<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GetUserOrPass;
use App\Http\Controllers\RecipesController;

// TO-DO: add middleware 
Route::middleware(GetUserOrPass::class)->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'index')->name('index');
    Route::get('/pending-recipes', [RecipesController::class, 'pendingRecipes'])->name('pending-recipes');
    Route::patch('/recipes/{id}/approve', [RecipesController::class, 'approve'])->name('recipes.approve');
    Route::patch('/recipes/{id}/reject', [RecipesController::class, 'reject'])->name('recipes.reject');
});
