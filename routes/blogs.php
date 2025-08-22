<?php

use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\BlogsController;

Route::middleware(GetUserOrPass::class)->prefix('blogs')->name('blogs.')->group(function () {
    // routes that need user authentication
    Route::middleware(RequireLogin::class)->group(function () {
        Route::get('/new-post', fn() => view('blogs.create'))->name('create');
    });

    Route::get('/', [BlogsController::class, 'index'])->name('index');
    Route::get('/{id}', [BlogsController::class, 'show'])->name('show');
});
