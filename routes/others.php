<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::middleware(GetUserOrPass::class)->group(function () {
    Route::get('/', fn() => view('index'))->name('home');
    Route::view('/about', 'about.index')->name('about');
    Route::view('/contact', 'contact.index')->name('contact');
    Route::post('/contact', [GeneralController::class, 'submitContactForm'])->name('contact.submit');
    Route::view('/educational-resources', 'edu.index')->name('edu.index');
});
