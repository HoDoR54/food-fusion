<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)->prefix('users')->name('users.')->group(function () {
    Route::get('/{id}', fn($id) => view('users.show', [
        'user' => Auth::user(),
    ]))->name('show');
});