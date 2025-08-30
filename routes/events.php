<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

Route::middleware(GetUserOrPass::class)->prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    // for js
    Route::get('/all', [EventsController::class, 'getEvents'])->name('all');
    Route::get('/{id}', [EventsController::class, 'show'])->name('show');
});
