<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\SortRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Services\CloudinaryService;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class RecipesController extends Controller
{
    protected RecipeService $_recipeService;

    protected CloudinaryService $_cloudinaryService;

    public function __construct(RecipeService $recipeService, CloudinaryService $cloudinaryService)
    {
        $this->_recipeService = $recipeService;
        $this->_cloudinaryService = $cloudinaryService;
    }

    public function index(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort)
    {
        $res = $this->_recipeService->getApprovedRecipes($pagination, $search, $sort);
        Log::info('Response:'.json_encode($res));

        if (! $res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('home');
        }

        return view('recipes.index', [
            'res' => $res,
            'title' => 'Recipes',
        ]);
    }

    public function pendingRecipes(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort)
    {
        $res = $this->_recipeService->getPendingRecipes($pagination, $search, $sort);
        Log::info('Response:'.json_encode($res->getData()->getItems()));

        if (! $res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('admin.index');
        }

        return view('recipes.pending-recipes', [
            'res' => $res,
            'title' => 'Pending Recipes',
        ]);
    }

    public function show($id)
    {
        $res = $this->_recipeService->getRecipeDetailsById($id);

        if (! $res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.index');
        }

        return view('recipes.show', [
            'res' => $res,
        ]);
    }

    // API method for getting recipes
    public function getRecipes(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort)
    {
        Log::info('getRecipes hit');
        $res = $this->_recipeService->getApprovedRecipes($pagination, $search, $sort);

        if (! $res->isSuccess()) {
            Log::info('getRecipes failed: '.$res->getMessage());

            return response()->json([
                'message' => $res->getMessage(),
                'data' => null,
                'pagination' => null,
            ], $res->getStatusCode());
        }

        $resData = $res->getData();
        Log::info('getRecipes successful', $resData->toArray());

        return response()->json([
            'message' => $res->getMessage(),
            'data' => $resData->getItems(),
            'pagination' => $resData->getPagination(),
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
            if (! $result->isSuccess()) {
                Log::warning('Recipe image upload failed', [
                    'user_id' => $userId,
                    'error' => $result->getMessage(),
                    'file_name' => $request->file('image')->getClientOriginalName(),
                ]);
                session()->flash('toastMessage', $result->getMessage());
                session()->flash('toastType', 'error');

                return back()->withInput();
            }
            $imageUrl = $result->getData()->secure_url;
            Log::info('Recipe image uploaded successfully', [
                'user_id' => $userId,
                'image_url' => $imageUrl,
            ]);
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

        if (! $userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to save recipes',
                ], 401);
            }

            session()->flash('toastMessage', 'You must be logged in to save recipes');
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.show', ['id' => $id]);
        }

        $res = $this->_recipeService->saveRecipeToUserProfile($userId, $id);

        if (! $res->isSuccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $res->getMessage(),
                ], 400);
            }

            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.show', ['id' => $id]);
        } else {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $res->getMessage(),
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

        if (! $userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to unsave recipes',
                ], 401);
            }

            session()->flash('toastMessage', 'You must be logged in to unsave recipes');
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.show', ['id' => $id]);
        }

        $res = $this->_recipeService->unsaveRecipeFromUserProfile($userId, $id);

        if (! $res->isSuccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $res->getMessage(),
                ], 400);
            }

            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.show', ['id' => $id]);
        } else {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $res->getMessage(),
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

        if (! $userId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User not authenticated',
                    'data' => ['is_saved' => false],
                ], 200);
            }

            return redirect()->route('recipes.show', ['id' => $id]);
        }

        $res = $this->_recipeService->isRecipeSaved($userId, $id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $res->isSuccess(),
                'message' => $res->getMessage(),
                'data' => $res->getData(),
            ], $res->isSuccess() ? 200 : 400);
        }

        session()->flash('toastMessage', $res->getMessage());
        session()->flash('toastType', $res->isSuccess() ? 'success' : 'error');

        return redirect()->route('recipes.show', ['id' => $id]);
    }

    // AJAX
    public function storeAttempt(Request $request)
    {
        $userId = auth()->id();

        $imageUrl = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Log::info('Processing image upload for recipe attempt', [
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_size' => $request->file('image')->getSize(),
                'mime_type' => $request->file('image')->getMimeType(),
            ]);

            $result = $this->_cloudinaryService->uploadImage($request->file('image'), 'recipe_attempts');
            if (! $result->isSuccess()) {
                Log::error('Cloudinary upload failed for recipe attempt', [
                    'error' => $result->getMessage(),
                    'user_id' => $userId,
                    'recipe_id' => $request->input('recipe_id'),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $result->getMessage(),
                ], 422);
            }
            $imageUrl = $result->getData()->secure_url;
            Log::info('Cloudinary upload successful', ['image_url' => $imageUrl]);
        } else {
            Log::info('No image file provided for recipe attempt');
        }

        $res = $this->_recipeService->storeRecipeAttempt($request, $userId, $imageUrl);

        if ($res->isSuccess()) {
            return response()->json([
                'success' => true,
                'message' => $res->getMessage(),
                'data' => $res->getData(),
            ], $res->getStatusCode());
        } else {
            return response()->json([
                'success' => false,
                'data' => $res->getData(),
                'message' => $res->getMessage(),
            ], $res->getStatusCode());
        }
    }

    public function approve(Request $request, string $id)
    {
        Log::info('Recipe approval initiated', ['recipe_id' => $id, 'user_id' => auth()->id()]);
        $res = $this->_recipeService->approveRecipe($id, auth()->id());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $res->isSuccess(),
                'message' => $res->getMessage(),
            ], $res->isSuccess() ? 200 : 400);
        }

        session()->flash('toastMessage', $res->getMessage());
        session()->flash('toastType', $res->isSuccess() ? 'success' : 'error');

        return redirect()->route('admin.pending-recipes');
    }

    public function reject(Request $request, string $id)
    {
        Log::info('Recipe rejection initiated', ['recipe_id' => $id, 'user_id' => auth()->id()]);
        $res = $this->_recipeService->rejectRecipe($id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $res->isSuccess(),
                'message' => $res->getMessage(),
            ], $res->isSuccess() ? 200 : 400);
        }

        session()->flash('toastMessage', $res->getMessage());
        session()->flash('toastType', $res->isSuccess() ? 'success' : 'error');

        return redirect()->route('admin.pending-recipes');
    }

    public function download($id)
    {
        $res = $this->_recipeService->getRecipeDetailsById($id);

        if (! $res->isSuccess()) {
            session()->flash('toastMessage', $res->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->route('recipes.index');
        }

        $recipe = $res->getData();

        $pdf = PDF::loadView('recipes.pdf', ['recipe' => $recipe]);

        $filename = preg_replace('/[^A-Za-z0-9\-_]/', '_', $recipe->name);
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = trim($filename, '_');

        return $pdf->download($filename.'.pdf');
    }
}
