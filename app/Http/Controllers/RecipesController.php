<?php

namespace App\Http\Controllers;

use App\Services\RecipeService;

class RecipesController extends Controller
{
    protected RecipeService $_recipeService;

    public function __construct(RecipeService $recipeService) {
        $this->_recipeService = $recipeService;
    }

    public function getAll() {
            $recipes = $this->_recipeService->getRecipes();
            return response()->json(['data' => $recipes], 200);
    }
}
