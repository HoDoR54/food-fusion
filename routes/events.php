<?php

use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

Route::middleware(GetUserOrPass::class)->prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    Route::get('/all', [EventsController::class, 'getEvents'])->name('all');
    Route::get('/get-by-id/{id}', [EventsController::class, 'getById'])->name('get');
    Route::get('/{id}', [EventsController::class, 'show'])->name('show');

    Route::middleware(RequireLogin::class)->group(function () {
        Route::post('/{id}/register', [EventsController::class, 'register'])->name('register');
    });
});
