<?php

use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogsController;

Route::middleware(GetUserOrPass::class)->prefix('blogs')->name('blogs.')->group(function () {
    Route::middleware(RequireLogin::class)->group(function () {
        Route::get('/new-post', fn() => view('blogs.create'))->name('create');
        Route::post('/{id}/comments/create', [BlogsController::class, 'createComment'])->name('comments.create');
        Route::post('/{id}/upvote', [BlogsController::class, 'upvote'])->name('upvote');
        Route::post('/{id}/downvote', [BlogsController::class, 'downvote'])->name('downvote');
    });

    Route::get('/', [BlogsController::class, 'index'])->name('index');
    Route::get('/all', [BlogsController::class, 'getAll'])->name('all');
    Route::get('/{id}', [BlogsController::class, 'show'])->name('show');
});
