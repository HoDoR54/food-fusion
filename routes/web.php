<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/photo-upload', [PhotoController::class, 'create'])->name('photos.create');
Route::post('/photo-upload', [PhotoController::class, 'store'])->name('photos.store');
Route::delete('/photo/{public_id}', [PhotoController::class, 'destroy'])->name('photos.destroy');

require __DIR__.'/auth.php';
require __DIR__.'/recipes.php';
require __DIR__.'/blogs.php';
require __DIR__.'/events.php';
require __DIR__.'/users.php';
require __DIR__.'/static.php';


