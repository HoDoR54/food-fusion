<?php

namespace App\Http\Controllers\Modules;

use App\Services\RecipeService;
use App\DTO\Responses\BaseResponse;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\SortRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\DTO\Responses\PaginatedResponse;
use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
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

    public function index(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort) {
        $res = $this->_recipeService->getApprovedRecipes($pagination, $search, $sort);

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

        $res = $this->_recipeService->storeRecipe($request, $userId, $imageUrl);

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

    public function saveToProfile(string $id)
    {
        $userId = auth()->id();
        $res = $this->_recipeService->saveRecipeToUserProfile($userId, $id);

        if (!$res->isSuccess()) {
            Log::error('Error saving recipe to profile: ' . $res->getMessage(), ['user_id' => $userId, 'recipe_id' => $id]);
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            Log::info('Flash message set for error', ['message' => $res->getMessage(), 'type' => 'error']);
        } else {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
            Log::info('Flash message set for success', ['message' => $res->getMessage(), 'type' => 'success']);
        }

        return redirect()->route('recipes.show', $id);
    }
}
