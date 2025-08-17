<?php

namespace App\Http\Controllers\Modules;

use App\Services\RecipeService;
use App\DTO\Responses\BaseResponse;
use Illuminate\Http\Request;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\DTO\Responses\PaginatedResponse;
use App\Http\Controllers\Controller;

class RecipesController extends Controller
{
    protected RecipeService $_recipeService;

    public function __construct(RecipeService $recipeService) {
        $this->_recipeService = $recipeService;
    }

    public function index(Request $request) {
        $paginationQuery = new PaginationQuery($request);
        $recipeFilterQuery = new RecipeSearchQuery($request);
        $sortQuery = new SortQuery($request);
        $res = $this->_recipeService->getRecipes($paginationQuery, $recipeFilterQuery, $sortQuery);

        if (!$res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            return redirect()->route('home');
        }

        return view('recipes.index', [
            'res' => $res,
            'title' => 'Recipes',
        ]);
    }

    public function show(Request $request, $id) {
        $res = $this->_recipeService->getRecipeDetailsById($id);
        
        if (!$res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            return redirect()->route('recipes.index');
        }

        return view('recipes.show', [
            'res' => $res
        ]);
    }
}
