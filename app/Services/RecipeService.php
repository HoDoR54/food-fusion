<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Ingredient;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\SortRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use App\Enums\TagType;

class RecipeService
{
    // Main Methods
    public function getApprovedRecipes(PaginationRequest $pagination, RecipeSearchRequest $search, SortRequest $sort): BaseResponse {
        $query = Recipe::query();
        $this->applyFilters($query, $search);
        $this->applySorting($query, $sort);
        $query->where('status', 'approved');

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
                'quantity' => $ingredientData['quantity'] ?? null,
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
