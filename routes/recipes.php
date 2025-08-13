<?php

use App\Http\Controllers\Modules\RecipesController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)->prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipesController::class, 'index'])->name('index');
    Route::get('/{id}', [RecipesController::class, 'show'])->name('show');
});
