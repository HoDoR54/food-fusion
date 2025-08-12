<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use Faker\Provider\Base;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeService
{
    protected RecipeRepo $_recipeRepo;

    public function __construct(RecipeRepo $recipeRepo) {
        $this->_recipeRepo = $recipeRepo;
    }

    public function getRecipes(PaginationQuery $paginationQuery, RecipeSearchQuery $recipeSearchQuery, SortQuery $sortQuery): PaginatedResponse {
        // Get the paginated recipes with filtering, sorting, and relations
        $paginator = $this->_recipeRepo->getRecipes($recipeSearchQuery, $sortQuery, $paginationQuery);

        // Map the recipes to the response format
        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        return PaginatedResponse::fromPaginator($paginator, $resData);
    }

    public function getRecipeById(string $id): BaseResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients']);
        
        if (!$recipe) {
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        return new BaseResponse(true, 'Recipe retrieved successfully', 200, $recipe);
    }
}
