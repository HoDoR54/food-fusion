<?php

namespace App\Http\Controllers;

use App\Services\RecipeService;
use App\DTO\Responses\BaseResponse;
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
            'recipes' => $paginatedRes->getData(),
            'pagination' => [
                'current_page' => $paginatedRes->getCurrentPage(),
                'total_pages' => $paginatedRes->getTotalPages(),
                'total_items' => $paginatedRes->getTotalItems(),
                'items_per_page' => $paginatedRes->getItemsPerPage(),
                'has_next_page' => $paginatedRes->getHasNextPage(),
                'has_previous_page' => $paginatedRes->getHasPreviousPage(),
            ],
            'title' => 'Recipes',
        ]);
    }

    public function show($id) {
        $recipe = $this->_recipeService->getRecipeById($id);
        return view('recipes.show', compact('recipe'));
    }

    // API endpoints that follow BaseResponse structure
    public function apiIndex(Request $request) {
        $paginationQuery = new PaginationQuery($request);
        $paginatedRes = $this->_recipeService->getRecipes($paginationQuery);
        
        $response = new BaseResponse(true, 'Recipes retrieved successfully', 200, $paginatedRes);
        return response()->json($response->toArray(), 200);
    }

    public function apiShow($id) {
        $recipe = $this->_recipeService->getRecipeById($id);
        
        if (!$recipe) {
            $response = new BaseResponse(false, 'Recipe not found', 404);
            return response()->json($response->toArray(), 404);
        }
        
        $response = new BaseResponse(true, 'Recipe retrieved successfully', 200, $recipe);
        return response()->json($response->toArray(), 200);
    }
}
