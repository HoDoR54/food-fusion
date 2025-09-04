<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::middleware(GetUserOrPass::class)->group(function () {
    // Main Pages
    Route::get('/', fn() => view('index'))->name('home');
    Route::view('/admin', 'admin')->name('admin.index');

    Route::prefix('info')->group(function () {
        // Route::view('/terms', 'info.terms')->name('terms');
        // Route::view('/privacy', 'info.privacy')->name('privacy');
        // Route::view('/cookies', 'info.cookies')->name('cookies');
        Route::view('/about-us', 'about.index')->name('about');
        Route::view('/educational-resources', 'edu.index')->name('edu.index');
    });
    
    // Contact & Communication
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::view('/', 'contact.index')->name('index');
        Route::post('/', [GeneralController::class, 'submitContactForm'])->name('submit');
    });
    
});
