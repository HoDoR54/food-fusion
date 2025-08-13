<?php

use App\Http\Controllers\Modules\RecipesController;
use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipesController::class, 'index'])->name('index');
    Route::get('/{id}', [RecipesController::class, 'show'])->name('show');
});
