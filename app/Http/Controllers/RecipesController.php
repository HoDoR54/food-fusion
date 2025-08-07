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
            'recipes' => $paginatedRes->data,
            'pagination' => [
                'current_page' => $paginatedRes->currentPage,
                'total_pages' => $paginatedRes->totalPages,
                'total_items' => $paginatedRes->totalItems,
                'items_per_page' => $paginatedRes->itemsPerPage,
                'has_next_page' => $paginatedRes->hasNextPage,
                'has_previous_page' => $paginatedRes->hasPreviousPage,
            ],
            'title' => 'Recipes',
        ]);
    }

    public function show($id) {
        $recipe = $this->_recipeService->getRecipeById($id);
        return view('recipes.show', compact('recipe'));
    }
}
