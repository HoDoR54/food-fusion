<?php

namespace App\Providers;

use App\Repositories\RecipeRepo;
use App\Repositories\IngredientRepo;
use App\Repositories\TagRepo;
use App\Services\RecipeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RecipeRepo::class, function ($app) {
            return new RecipeRepo(new \App\Models\Recipe());
        });

        $this->app->bind(IngredientRepo::class, function ($app) {
            return new IngredientRepo(new \App\Models\Ingredient());
        });

        $this->app->bind(TagRepo::class, function ($app) {
            return new TagRepo(new \App\Models\Tag());
        });

        $this->app->bind(RecipeService::class, function ($app) {
            return new RecipeService(
                $app->make(RecipeRepo::class),
                $app->make(IngredientRepo::class),
                $app->make(TagRepo::class)
            );
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
