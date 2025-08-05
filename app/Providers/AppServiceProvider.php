<?php

namespace App\Providers;

use App\Repositories\RecipeRepo;
use App\Services\RecipeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register RecipeRepo
        $this->app->bind(RecipeRepo::class, function ($app) {
            return new RecipeRepo(new \App\Models\Recipe());
        });

        // Register RecipeService
        $this->app->bind(RecipeService::class, function ($app) {
            return new RecipeService($app->make(RecipeRepo::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
