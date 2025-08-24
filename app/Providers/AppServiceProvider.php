<?php

namespace App\Providers;

use App\Repositories\IngredientRepo;
use App\Repositories\TagRepo;
use App\Services\RecipeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
