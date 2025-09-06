<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tag;
use App\Models\Ingredient;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\SortRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use App\Models\RecipeAttempt;
use App\Enums\TagType;
use App\Enums\RecipePostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipeService
{
    // Main Methods
    public function getApprovedRecipes(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort): BaseResponse {
        $query = Recipe::query();
        $this->applyFilters($query, $search);
        $this->applySorting($query, $sort);
        $query->where('status', RecipePostStatus::APPROVED);

        $paginator = $query->paginate(
            $pagination->input('size', 12), 
            ['*'], 
            'page', 
            $pagination->input('page', 1)
        );
        
        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);
        return new BaseResponse(true, 'Recipes retrieved successfully', 200, $paginatedRes);
    }

    public function getPendingRecipes(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort): BaseResponse {
        $query = Recipe::query();
        $this->applyFilters($query, $search);
        $this->applySorting($query, $sort);
        $query->where('status', RecipePostStatus::PENDING)->with(['postedBy', 'tags', 'ingredients']);

        $paginator = $query->paginate(
            $pagination->input('size', 12), 
            ['*'], 
            'page', 
            $pagination->input('page', 1)
        );
        
        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);
        Log::info('Pending Recipes Data:', $paginatedRes->toArray());
        return new BaseResponse(true, 'Pending recipes retrieved successfully', 200, $paginatedRes);
    }

    public function getRecipeDetailsById(string $id): BaseResponse {
        $recipe = Recipe::with(['postedBy', 'tags', 'ingredients', 'attempts'])->find($id);

        if (!$recipe) {
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        return new BaseResponse(true, 'Recipe retrieved successfully', 200, $recipe);
    }

    public function storeRecipe(StoreRecipeRequest $request, ?string $userId = null, ?string $imageUrl = null): BaseResponse
    {
        try {
            \DB::beginTransaction();

            $newRecipe = Recipe::create([
                'posted_by' => $userId,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'servings' => $request->input('servings'),
                'difficulty' => $request->input('difficulty'),
                'image_url' => $imageUrl,
                'steps' => $request->input('steps'),
            ]);

            if ($request->has('ingredients')) {
                $this->attachIngredients($newRecipe, $request->input('ingredients'));
            }
            if ($request->has('tags')) {
                $this->attachTags($newRecipe, $request->input('tags'));
            }

            \DB::commit();

            return new BaseResponse(true, 'Recipe created successfully! It will be reviewed before publication.', 201, $newRecipe);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error creating recipe: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->validated()
            ]);
            return new BaseResponse(false, 'Failed to create recipe. Please try again.', 500);
        }
    }

    public function saveRecipeToUserProfile(string $userId, string $recipeId): ?BaseResponse
    {
        try {
            \DB::beginTransaction();

            $user = User::find($userId);
            if (!$user) {
                Log::error('User not found when saving recipe', ['user_id' => $userId]);
                return new BaseResponse(false, 'User not found', 404);
            }

            $recipe = Recipe::find($recipeId);
            if (!$recipe) {
                Log::error('Recipe not found when saving', ['recipe_id' => $recipeId, 'user_id' => $userId]);
                return new BaseResponse(false, 'Recipe not found', 404);
            }

            // Check if recipe is already saved
            $alreadySaved = $user->savedRecipes()->where('recipe_id', $recipe->id)->exists();

            if ($alreadySaved) {
                Log::info('User attempted to save already saved recipe', [
                    'user_id' => $userId,
                    'recipe_id' => $recipeId
                ]);
                \DB::rollback();
                return new BaseResponse(false, 'Recipe already saved to profile', 409);
            }

            $user->savedRecipes()->attach($recipe->id);

            \DB::commit();
            return new BaseResponse(true, 'Recipe saved to profile successfully', 200);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error saving recipe to user profile', [
                'user_id' => $userId,
                'recipe_id' => $recipeId,
                'error' => $e->getMessage()
            ]);
            return new BaseResponse(false, 'Failed to save recipe to profile. Please try again.', 500);
        }
    }

    public function unsaveRecipeFromUserProfile(string $userId, string $recipeId): ?BaseResponse
    {
        try {
            \DB::beginTransaction();

            $user = User::find($userId);
            if (!$user) {
                Log::error('User not found when unsaving recipe', ['user_id' => $userId]);
                return new BaseResponse(false, 'User not found', 404);
            }

            $recipe = Recipe::find($recipeId);
            if (!$recipe) {
                Log::error('Recipe not found when unsaving', ['recipe_id' => $recipeId, 'user_id' => $userId]);
                return new BaseResponse(false, 'Recipe not found', 404);
            }

            // Check if recipe is not saved
            $notSaved = !$user->savedRecipes()->where('recipe_id', $recipe->id)->exists();

            if ($notSaved) {
                \DB::rollback();
                return new BaseResponse(false, 'This recipe is not saved to profile', 409);
            }

            $user->savedRecipes()->detach($recipe->id);

            \DB::commit();
            return new BaseResponse(true, 'Recipe unsaved from profile successfully', 200);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error unsaving recipe from user profile', [
                'user_id' => $userId,
                'recipe_id' => $recipeId,
                'error' => $e->getMessage()
            ]);
            return new BaseResponse(false, 'Failed to unsave recipe from profile. Please try again.', 500);
        }
    }

    public function isRecipeSaved(string $userId, string $recipeId): ?BaseResponse
    {
        $user = User::find($userId);
        if (!$user) {
            Log::error('User not found when checking saved recipe', ['user_id' => $userId]);
            return new BaseResponse(false, 'User not found', 404);
        }

        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            Log::error('Recipe not found when checking saved status', ['recipe_id' => $recipeId, 'user_id' => $userId]);
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        $isSaved = $user->savedRecipes()->where('recipe_id', $recipe->id)->exists();

        return new BaseResponse(true, 'Recipe saved status retrieved successfully', 200, ['is_saved' => $isSaved]);
    }

    public function storeRecipeAttempt(Request $request, string $userId, ?string $imageUrl): ?BaseResponse
    {
        try {
            \DB::beginTransaction();

            $recipeId = $request->input('recipe_id');
            $recipe = Recipe::find($recipeId);
            if (!$recipe) {
                Log::error('Recipe not found when storing attempt', ['recipe_id' => $recipeId, 'user_id' => $userId]);
                return new BaseResponse(false, 'Recipe not found', 404);
            }

            $attempt = new RecipeAttempt();
            $attempt->user_id = $userId;
            $attempt->recipe_id = $recipeId;
            $attempt->notes = $request->input('notes');
            $attempt->image_url = $imageUrl;
            $attempt->save();

            \DB::commit();
            return new BaseResponse(true, 'Recipe attempt shared successfully', 200);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('Error sharing recipe attempt', [
                'user_id' => $userId,
                'recipe_id' => $request->input('recipe_id'),
                'error' => $e->getMessage()
            ]);
            return new BaseResponse(false, 'Failed to share recipe attempt. Please try again.', 500);
        }
    }

    public function approveRecipe(string $recipeId, string $approvedBy): BaseResponse
    {
        try {
            \DB::beginTransaction();

            $recipe = Recipe::find($recipeId);
            if (!$recipe) {
                return new BaseResponse(false, 'Recipe not found', 404);
            }

            if ($recipe->status === RecipePostStatus::APPROVED) {
                return new BaseResponse(false, 'Recipe is already approved', 400);
            }

            $recipe->status = RecipePostStatus::APPROVED;
            $recipe->approved_by = $approvedBy;
            $recipe->approved_at = now();
            $recipe->save();

            \DB::commit();
            Log::info("Recipe approved successfully", ['recipe_id' => $recipeId, 'approved_by' => $approvedBy]);
            return new BaseResponse(true, 'Recipe approved successfully', 200);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error("Failed to approve recipe", ['recipe_id' => $recipeId, 'error' => $e->getMessage()]);
            return new BaseResponse(false, 'Failed to approve recipe', 500);
        }
    }

    public function rejectRecipe(string $recipeId): BaseResponse
    {
        try {
            \DB::beginTransaction();

            $recipe = Recipe::find($recipeId);
            if (!$recipe) {
                return new BaseResponse(false, 'Recipe not found', 404);
            }

            if ($recipe->status === RecipePostStatus::REJECTED) {
                return new BaseResponse(false, 'Recipe is already rejected', 400);
            }

            $recipe->status = RecipePostStatus::REJECTED;
            $recipe->save();

            \DB::commit();
            Log::info("Recipe rejected successfully", ['recipe_id' => $recipeId]);
            return new BaseResponse(true, 'Recipe rejected successfully', 200);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error("Failed to reject recipe", ['recipe_id' => $recipeId, 'error' => $e->getMessage()]);
            return new BaseResponse(false, 'Failed to reject recipe', 500);
        }
    }

    // Support Methods
    public function getDietaryPreferences(): array
    {
        return Tag::where('type', TagType::Dietary->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function getCuisineTypes(): array
    {
        return Tag::where('type', TagType::Origin->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function getCourses(): array
    {
        return Tag::where('type', TagType::Course->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function getCookingMethods(): array
    {
        return Tag::where('type', TagType::CookingMethod->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function getOccasions(): array
    {
        return Tag::where('type', TagType::Occasion->value)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }


    // Helpers
    private function applyFilters($query, RecipeSearchRequest $search): void
    {
        if ($search->filled('search_term')) {
            $term = '%' . $search->input('search_term') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                ->orWhere('description', 'like', $term)
                ->orWhere('steps', 'like', $term)
                ->orWhere('difficulty', 'like', $term);
                $q->orWhereHas('ingredients', function ($q) use ($term) {
                    $q->where('name', 'like', $term);
                });
                $q->orWhereHas('tags', function ($q) use ($term) {
                    $q->where('name', 'like', $term);
                });
                $q->orWhereHas('postedBy', function ($q) use ($term) {
                    $q->where('first_name', 'like', $term)
                      ->orWhere('last_name', 'like', $term)
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$term]);
                });
            });
        }

        // Author
        if ($search->filled('author')) {
            $query->whereHas('postedBy', function ($q) use ($search) {
                $term = '%' . $search->input('author') . '%';
                $q->where('first_name', 'like', $term)
                  ->orWhere('last_name', 'like', $term)
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$term]);
            });
        }
        
        // Ingredient
        if ($search->filled('ingredient')) {
            $query->whereHas('ingredients', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search->input('ingredient') . '%');
            });
        }

        // Difficulty level 
        if ($search->filled('difficulty_level')) {
            $query->where('difficulty', $search->input('difficulty_level'));
        }

        // Dietary preference 
        if ($search->filled('dietary_preference')) {
            $query->whereHas('tags', function ($q) use ($search) {
                $q->where('type', 'dietary')
                  ->where('name', 'like', '%' . $search->input('dietary_preference') . '%');
            });
        }

        // Cuisine type (origin) 
        if ($search->filled('cuisine_type')) {
            $query->whereHas('tags', function ($q) use ($search) {
                $q->where('type', 'origin')
                  ->where('name', 'like', '%' . $search->input('cuisine_type') . '%');
            });
        }

        // Course 
        if ($search->filled('course')) {
            $query->whereHas('tags', function ($q) use ($search) {
                $q->where('type', 'course')
                  ->where('name', 'like', '%' . $search->input('course') . '%');
            });
        }

        // Cooking method 
        if ($search->filled('cooking_method')) {
            $query->whereHas('tags', function ($q) use ($search) {
                $q->where('type', 'method')
                  ->where('name', 'like', '%' . $search->input('cooking_method') . '%');
            });
        }

        // Occasion
        if ($search->filled('occasion')) {
            $query->whereHas('tags', function ($q) use ($search) {
                $q->where('type', 'occasion')
                  ->where('name', 'like', '%' . $search->input('occasion') . '%');
            });
        }
    }

    private function applySorting($query, SortRequest $sort): void
    {
        // Define allowed sortable columns
        $allowedSortColumns = ['name', 'created_at', 'updated_at', 'difficulty', 'servings'];
        
        $sortBy = $sort->input('sort_by', 'created_at');
        $sortDirection = $sort->input('sort_direction', 'desc');
        
        if ($sortBy === 'popularity') {
            // Sort by number of recipe attempts (popularity)
            $query->withCount('attempts')
                  ->orderBy('attempts_count', $sortDirection)
                  ->orderBy('created_at', 'desc'); // Secondary sort for consistency
        } elseif (in_array($sortBy, $allowedSortColumns)) {
            // Sort by regular columns
            $query->orderBy($sortBy, $sortDirection);
            
            // Add secondary sort for consistency when primary values are equal
            if ($sortBy !== 'created_at') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default fallback sorting
            $query->orderBy('created_at', 'desc');
        }
    }

    private function attachIngredients(Recipe $recipe, array $ingredients): void
    {
        foreach ($ingredients as $ingredientData) {
            $ingredient = Ingredient::firstOrCreate(
                ['name' => $ingredientData['name']],
                ['description' => '']
            );

            $recipe->ingredients()->attach($ingredient->id, [
                'amount' => $ingredientData['amount'] ?? null,
                'unit' => $ingredientData['unit'] ?? null,
            ]);
        }
    }

    private function attachTags(Recipe $recipe, array $tags): void
    {
        $tagIds = [];
        
        foreach ($tags as $tagData) {
            if (empty($tagData['name'])) {
                continue;
            }

            $tag = Tag::firstOrCreate(
                ['name' => $tagData['name'], 'type' => $tagData['type']]
            );

            $tagIds[] = $tag->id;
        }

        $recipe->tags()->attach($tagIds);
    }

    private function uploadRecipeImage($image): ?string
    {
        $path = $image->store('recipes', 'public');
        return asset('storage/' . $path);
    }
}
