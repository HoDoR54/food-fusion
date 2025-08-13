<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->prefix('events')->name('events.')->group(function () {
    Route::get('/', fn() => view('events.index'))->name('index');
    Route::get('/{id}', fn($id) => view('events.show', ['id' => $id]))->name('show');
});
