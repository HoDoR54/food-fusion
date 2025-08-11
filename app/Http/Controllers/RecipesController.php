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
            'res' => $paginatedRes,
            'title' => 'Recipes',
        ]);
    }

    public function show($id) {
        $recipe = $this->_recipeService->getRecipeById($id);
        
        if (!$recipe) {
            session()->flash('toastMessage', 'Recipe not found.');
            session()->flash('toastType', 'error');
            return redirect()->route('recipes.index');
        }
        
        return view('recipes.show', compact('recipe'));
    }
}
