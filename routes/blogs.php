<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)->prefix('blogs')->name('blogs.')->group(function () {
    Route::get('/', fn() => view('blogs.index'))->name('index');
    Route::get('/new', fn() => view('blogs.create'))->name('create');
    Route::get('/{id}', fn($id) => view('blogs.show', ['id' => $id]))->name('show');
});
