<?php

use App\Http\Controllers\Modules\RecipesController;
use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipesController::class, 'index'])->name('index');
    Route::get('/new-recipe', [RecipesController::class, 'showStore'])->name('create.show');
    Route::post('/new-recipe', [RecipesController::class, 'store'])->name('store');
    Route::get('/{id}', [RecipesController::class, 'show'])->name('show');
});
