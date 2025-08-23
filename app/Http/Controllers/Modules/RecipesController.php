<?php

namespace App\Http\Controllers\Modules;

use App\Services\RecipeService;
use App\DTO\Responses\BaseResponse;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\Http\Requests\StoreRecipeRequest;
use App\DTO\Responses\PaginatedResponse;
use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use App\DTO\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipesController extends Controller
{
    protected RecipeService $_recipeService;
    protected CloudinaryService $_cloudinaryService;

    public function __construct(RecipeService $recipeService, CloudinaryService $cloudinaryService) {
        $this->_recipeService = $recipeService;
        $this->_cloudinaryService = $cloudinaryService;
    }

    public function index(Request $request) {
        $paginationQuery = new PaginationQuery($request);
        $recipeFilterQuery = new RecipeSearchQuery($request);
        $sortQuery = new SortQuery($request);
        $res = $this->_recipeService->getApprovedRecipes($paginationQuery, $recipeFilterQuery, $sortQuery);

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
        $imageUrl = null;
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $result = $this->_cloudinaryService->uploadImage($request->file('image'), 'recipes');
            if (!$result->isSuccess()) {
                session()->flash('toastMessage', $result->getMessage());
                session()->flash('toastType', 'error');
                return back()->withInput();
            }
            $imageUrl = $result->getData()->secure_url;
        }

        $validatedData = $request->validated();
        unset($validatedData['image']);

        $res = $this->_recipeService->storeRecipe($validatedData, $userId, $imageUrl);

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
