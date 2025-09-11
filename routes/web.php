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
    // Session routes
    Route::prefix('sessions')->name('sessions.')->group(function () {
        Route::post('/set', function (Illuminate\Http\Request $request) {
            Log::info('set route hit');
            $key = $request->input('key');
            $value = $request->input('value');
            session([$key => $value]);
            Log::info('session set:', ['key' => $key, 'value' => session($key)]);

            return response()->json(['success' => true]);
        })->name('set');
        Route::get('/{key}/get', function ($key) {
            Log::info('get route hit');

            return response()->json([
                'value' => session($key),
            ]);
        })->name('get');
    });

    // Static Routes
    Route::view('/', 'index')->name('home');
    Route::view('/about-us', 'static.about')->name('about');
    Route::view('/privacy-and-cookies-policies', 'static.policies')->name('policies');
    Route::view('/terms-and-conditions', 'static.terms')->name('terms');
    Route::view('/volunteer-opportunities', 'static.volunteer')->name('volunteer');
    Route::view('/support', 'static.support')->name('support');
    
    // Culinary and Educational Resources
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::view('/', 'resources.index')->name('index');
        Route::view('/culinary-resources', 'resources.culinary')->name('culinary');
        Route::view('/educational-resources', 'resources.edu')->name('edu');
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
