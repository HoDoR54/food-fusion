<?php

namespace App\Repositories;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\SortRequest;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo extends AbstractRepo
{
    public function __construct(Recipe $recipe) {
        parent::__construct($recipe);
    }

    public function getRecipes(RecipeSearchRequest $search, SortRequest $sort, PaginationRequest $pagination): LengthAwarePaginator {
        return $this->getApprovedRecipes($search, $sort, $pagination);
    }

    public function getApprovedRecipes (RecipeSearchRequest $search, SortRequest $sort, PaginationRequest $pagination): LengthAwarePaginator {
        $query = $this->model->newQuery();

        $this->applyFilters($query, $search);
        $this->applySorting($query, $sort);
        $query->where('status', 'approved');

        $query->with(['postedBy', 'tags', 'ingredients']);
        $paginator = $query->paginate(
            $pagination->input('size', 15), 
            ['*'], 
            'page', 
            $pagination->input('page', 1)
        );
        return $paginator;
    }

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

    public function getTagsByType(string $type): array
    {
        return Tag::where('type', $type)
            ->distinct()
            ->pluck('name')
            ->toArray();
    }

    public function attachIngredient(Recipe $recipe, string $ingredientId, array $pivotData): void
    {
        $recipe->ingredients()->attach($ingredientId, $pivotData);
    }

    public function attachTags(Recipe $recipe, array $tagIds): void
    {
        if (!empty($tagIds)) {
            $recipe->tags()->attach($tagIds);
        }
    }
}