<?php

use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->prefix('blogs')->name('blogs.')->group(function () {
    // routes that need user authentication
    Route::middleware(RequireLogin::class)->group(function () {
        Route::get('/new-post', fn() => view('blogs.create'))->name('create');
    });

    Route::get('/', fn() => view('blogs.index'))->name('index');
    Route::get('/{id}', fn($id) => view('blogs.show', ['id' => $id]))->name('show');
});
