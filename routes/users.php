<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->prefix('users')->name('users.')->group(function () {
    Route::get('/{id}', fn($id) => view('users.show', [
        'user' => Auth::user(),
    ]))->name('show');
});