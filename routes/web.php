<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GetUserOrPass;
use App\Http\Middleware\RequireLogin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\EventsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::pattern('uuid', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');

// public routes
Route::middleware(GetUserOrPass::class)->group(function () {
    // Static Routes
    Route::view('/', 'index')->name('home');
    Route::view('/about-us', 'about.index')->name('about');
    
    // Info Pages
    Route::prefix('info')->group(function () {
        Route::view('/educational-resources', 'edu.index')->name('edu.index');
    });

    // authentication routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login.show');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register.show');
    
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware(App\Http\Middleware\CheckFailedLoginAttempts::class)
            ->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // RESOURCE-BASED ROUTES
    // Recipes
    Route::prefix('recipes')->name('recipes.')->group(function () {
        Route::get('/', [RecipesController::class, 'index'])->name('index');
        Route::get('/{uuid}', [RecipesController::class, 'show'])->name('show');
        Route::get('/{uuid}/download', [RecipesController::class, 'download'])->name('download');
    });

    // Blogs
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogsController::class, 'index'])->name('index');
        Route::get('/{uuid}', [BlogsController::class, 'show'])->name('show');
    });

    // Events
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventsController::class, 'index'])->name('index');
        Route::get('/{uuid}', [EventsController::class, 'show'])->name('show');
    });


    // Contact Routes
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::view('/', 'contact.index')->name('index');
    });

    // Users
    Route::name('users.')->prefix('users')->group(function () {
        //
    });
});

// authenticated user routes
Route::middleware([GetUserOrPass::class, RequireLogin::class])->group(function () {
    // Recipes
    Route::prefix('recipes')->name('recipes.')->group(function () {
        Route::view('/new-recipe', 'recipes.create')->name('create.show');
        Route::post('/new-recipe', [RecipesController::class, 'store'])->name('store');
    });

    // Blogs
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/new-post', [BlogsController::class, 'create'])->name('create');
        Route::post('/new-post', [BlogsController::class, 'store'])->name('store');
    });
});

// admin routes
Route::middleware([GetUserOrPass::class, RequireLogin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.index')->name('index');
    Route::get('/pending-recipes', [RecipesController::class, 'pendingRecipes'])->name('pending-recipes');
});

// putting this at the end to avoid conflicts
// user profile route uses username as a slug in the URL
Route::get('/{username}', function ($username) {
    $profileUser = User::where('username', $username)->first();
    
    if (!$profileUser) {
        abort(404, 'User not found');
    }
    
    return view('users.show', [
        'user' => Auth::user(),
        'profileUser' => $profileUser,
    ]);
})->name('users.show');
