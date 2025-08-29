<?php

use App\Http\Controllers\RecipesController;
use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;


Route::middleware([GetUserOrPass::class, RequireLogin::class])->prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/new-recipe', [RecipesController::class, 'showStore'])->name('create.show');
    Route::post('/new-recipe', [RecipesController::class, 'store'])->name('store');
    Route::post('/attempt', [RecipesController::class, 'storeAttempt'])->name('attempt.store');
    Route::post('/{id}/save', [RecipesController::class, 'saveToProfile'])->name('save');
    Route::post('/{id}/unsave', [RecipesController::class, 'unsaveFromProfile'])->name('unsave');
    Route::get('/{id}/is-saved', [RecipesController::class, 'isSaved'])->name('is.saved');
});

Route::middleware(GetUserOrPass::class)->prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipesController::class, 'index'])->name('index');
    Route::get('/{id}', [RecipesController::class, 'show'])->name('show');
});


