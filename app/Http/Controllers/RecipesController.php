<?php

namespace App\Http\Controllers;

use App\Services\RecipeService;
use Illuminate\Http\Request;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Responses\PaginatedResponse;

class RecipesController extends Controller
{
    protected RecipeService $_recipeService;

    public function __construct(RecipeService $recipeService) {
        $this->_recipeService = $recipeService;
    }

    public function index(Request $request) {
        $paginationQuery = new PaginationQuery($request);
        $paginatedRes = $this->_recipeService->getRecipes($paginationQuery);

        return view('recipes.index', [
            'title' => 'Recipes',
            'paginatedRecipes' => new PaginatedResponse(
                $paginatedRes->items,
                $paginatedRes->total,
                $paginatedRes->page,
                $paginatedRes->size
            )
        ]);
    }


    public function show($id) {
        $recipe = $this->_recipeService->getRecipeById($id);
        return view('recipes.show', compact('recipe'));
    }
}
