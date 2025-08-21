<?php

namespace App\Http\Controllers\Modules;

use App\Services\RecipeService;
use App\DTO\Responses\BaseResponse;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\DTO\Requests\StoreRecipeRequest;
use App\DTO\Responses\PaginatedResponse;
use App\Http\Controllers\Controller;
use App\DTO\Requests;
use Illuminate\Http\Request;

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

    public function show($id)
    {
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

    public function showStore()
    {
        return view('recipes.create', [
            'title' => 'Create New Recipe',
        ]);
    }

    public function store(StoreRecipeRequest $request)
    {
        $userId = auth()->id();
        
        $res = $this->_recipeService->storeRecipe($request->validated(), $userId);

        if ($res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
            return redirect()->route('recipes.index');
        } else {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            return back()->withInput();
        }
    }
}
