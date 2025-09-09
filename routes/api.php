<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\GeneralController;

// For AJAX and API requests
Route::middleware(GetUserOrPass::class)->group(function () {
    // Session routes
    Route::prefix('sessions')->name('sessions.')->group(function () {
        Route::post('/set', function (Illuminate\Http\Request $request) {
            $key = $request->input('key');
            $value = $request->input('value');
            session([$key => $value]);
            return response()->json(['success' => true]);
        })->name('set');
        Route::get('/{key}/get', function ($key) {
            return response()->json([
                'value' => session($key),
            ]);
        })->name('get');
    });

    // Events (public API routes)
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/all', [EventsController::class, 'getEvents'])->name('all');
        Route::get('/get-by-id/{id}', [EventsController::class, 'getById'])->name('get');
    });

    // Blogs (public API routes)
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/all', [BlogsController::class, 'getAll'])->name('all');
    });

    // Contact
    Route::post('/contact', [GeneralController::class, 'submitContactForm'])->name('contact.submit');

    // Authenticated API routes
    Route::middleware(RequireLogin::class)->group(function () {
        // Recipes
        Route::prefix('recipes')->name('recipes.')->group(function () {
            Route::post('/attempts/create', [RecipesController::class, 'storeAttempt'])->name('attempt.store');
            Route::post('/{id}/save', [RecipesController::class, 'saveToProfile'])->name('save');
            Route::post('/{id}/unsave', [RecipesController::class, 'unsaveFromProfile'])->name('unsave');
            Route::get('/{id}/is-saved', [RecipesController::class, 'isSaved'])->name('is.saved');
        });

        // Blogs
        Route::prefix('blogs')->name('blogs.')->group(function () {
            Route::post('/{id}/comments/create', [BlogsController::class, 'createComment'])->name('comments.create');
            Route::post('/{id}/upvote', [BlogsController::class, 'upvote'])->name('upvote');
            Route::post('/{id}/downvote', [BlogsController::class, 'downvote'])->name('downvote');
        });

        // Events
        Route::prefix('events')->name('events.')->group(function () {
            Route::post('/{id}/register', [EventsController::class, 'register'])->name('register');
        });
    });
});

// Admin API Routes
Route::middleware([GetUserOrPass::class, RequireLogin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('recipes')->name('recipes.')->group(function () {
        Route::patch('/{id}/approve', [RecipesController::class, 'approve'])->name('approve');
        Route::patch('/{id}/reject', [RecipesController::class, 'reject'])->name('reject');
    });
});