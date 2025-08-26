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

    public function saveToProfile(Request $request, string $id)
    {
        $userId = auth()->id();
        
        if (!$userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to save recipes'
                ], 401);
            }
            
            session()->flash('toastMessage', 'You must be logged in to save recipes');
            session()->flash('toastType', 'error');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        }
        
        $res = $this->_recipeService->saveRecipeToUserProfile($userId, $id);

        if (!$res->isSuccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $res->getMessage()
                ], 400);
            }
            
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        } else {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $res->getMessage()
                ], 200);
            }
            
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        }
    }

    public function unsaveFromProfile(Request $request, string $id)
    {
        $userId = auth()->id();
        
        if (!$userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to unsave recipes'
                ], 401);
            }
            
            session()->flash('toastMessage', 'You must be logged in to unsave recipes');
            session()->flash('toastType', 'error');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        }
        
        $res = $this->_recipeService->unsaveRecipeFromUserProfile($userId, $id);

        if (!$res->isSuccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $res->getMessage()
                ], 400);
            }
            
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        } else {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $res->getMessage()
                ], 200);
            }
            
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
            
            return redirect()->route('recipes.show', ['id' => $id]);
        }
    }

    public function isSaved(Request $request, string $id)
    {
        $userId = auth()->id();

        if (!$userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User not authenticated',
                    'data' => ['is_saved' => false]
                ], 200);
            }
            
            return redirect()->route('recipes.show', ['id' => $id]);
        }

        $res = $this->_recipeService->isRecipeSaved($userId, $id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $res->isSuccess(),
                'message' => $res->getMessage(),
                'data' => $res->getData()
            ], $res->isSuccess() ? 200 : 400);
        }

        session()->flash('toastMessage', $res->getMessage());
        session()->flash('toastType', $res->isSuccess() ? 'success' : 'error');

        return redirect()->route('recipes.show', ['id' => $id]);
    }

    public function storeAttempt(Request $request)
    {
        $userId = auth()->id();

        $imageUrl = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $result = $this->_cloudinaryService->uploadImage($request->file('image'), 'recipe_attempts');
            if (!$result->isSuccess()) {
                session()->flash('toastMessage', $result->getMessage());
                session()->flash('toastType', 'error');
                return redirect()->route('recipes.show', ['id' => $request->input('recipe_id')]);
            }
            $imageUrl = $result->getData()->secure_url;
        }

        $res = $this->_recipeService->storeRecipeAttempt($request, $userId, $imageUrl);

        if ($res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'success');
        } else {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->route('recipes.show', ['id' => $request->input('recipe_id')]);
    }
}
