<?php

namespace App\Repositories;

use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo extends AbstractRepo
{
    public function __construct(Recipe $recipe) {
        parent::__construct($recipe);
    }

    public function getRecipes(RecipeSearchQuery $searchQ, SortQuery $sortQ, PaginationQuery $paginationQ): LengthAwarePaginator {
        return $this->getApprovedRecipes($searchQ, $sortQ, $paginationQ);
    }

    public function getApprovedRecipes (RecipeSearchQuery $searchQ, SortQuery $sortQ, PaginationQuery $paginationQ): LengthAwarePaginator {
        $query = $this->model->newQuery();

        $this->applyFilters($query, $searchQ);
        $this->applySorting($query, $sortQ);
        $query->where('status', 'approved');

        $query->with(['postedBy', 'tags', 'ingredients']);
        $paginator = $query->paginate($paginationQ->getSize(), ['*'], 'page', $paginationQ->getPage());
        return $paginator;
    }

    private function applyFilters($query, RecipeSearchQuery $searchQ): void
    {
        if ($searchQ->hasFilters()) {
            if ($searchQ->getSearchTerm()) {
                $term = '%' . $searchQ->getSearchTerm() . '%';
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

            // author
            if ($searchQ->getSearchAuthor()) {
                $query->whereHas('postedBy', function ($q) use ($searchQ) {
                    $term = '%' . $searchQ->getSearchAuthor() . '%';
                    $q->where('first_name', 'like', $term)
                      ->orWhere('last_name', 'like', $term)
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$term]);
                });
            }
            
            // ingredient
            if ($searchQ->getSearchIngredient()) {
                $query->whereHas('ingredients', function ($q) use ($searchQ) {
                    $q->where('name', 'like', '%' . $searchQ->getSearchIngredient() . '%');
                });
            }

            // difficulty
            if ($searchQ->getSearchDifficultyLevel()) {
                $query->where('difficulty', $searchQ->getSearchDifficultyLevel());
            }

            // dietary preference
            if ($searchQ->getDietaryPreference()) {
                $query->whereHas('tags', function ($q) use ($searchQ) {
                    $q->where('type', 'dietary')
                      ->where('name', 'like', '%' . $searchQ->getDietaryPreference() . '%');
                });
            }

            // cuisine type (origin)
            if ($searchQ->getCuisineType()) {
                $query->whereHas('tags', function ($q) use ($searchQ) {
                    $q->where('type', 'origin')
                      ->where('name', 'like', '%' . $searchQ->getCuisineType() . '%');
                });
            }

            // course
            if ($searchQ->getCourse()) {
                $query->whereHas('tags', function ($q) use ($searchQ) {
                    $q->where('type', 'course')
                      ->where('name', 'like', '%' . $searchQ->getCourse() . '%');
                });
            }

            // cooking method
            if ($searchQ->getCookingMethod()) {
                $query->whereHas('tags', function ($q) use ($searchQ) {
                    $q->where('type', 'method')
                      ->where('name', 'like', '%' . $searchQ->getCookingMethod() . '%');
                });
            }

            // occasion
            if ($searchQ->getOccasion()) {
                $query->whereHas('tags', function ($q) use ($searchQ) {
                    $q->where('type', 'occasion')
                      ->where('name', 'like', '%' . $searchQ->getOccasion() . '%');
                });
            }
        }
    }


    private function applySorting($query, SortQuery $sortQ): void
    {
        if ($sortQ->hasSort()) {
            $query->orderBy($sortQ->getSortBy(), $sortQ->getSortDirection());
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