<?php

use App\Http\Middleware\GetUserOrPass;
use Illuminate\Support\Facades\Route;

Route::middleware(GetUserOrPass::class)->group(function () {
    Route::get('/', fn() => view('index'))->name('home');
    Route::view('/about', 'static.about')->name('about');
    Route::view('/contact', 'static.contact')->name('contact');
    Route::view('/educational-resources', 'edu.index')->name('edu.index');
});
