<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Requests\RecipeSearchQuery;
use App\DTO\Requests\SortQuery;
use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use App\Enums\TagType;

class RecipeService
{
    protected RecipeRepo $_recipeRepo;

    public function __construct(RecipeRepo $recipeRepo) {
        $this->_recipeRepo = $recipeRepo;
    }

    public function getRecipes(PaginationQuery $paginationQuery, RecipeSearchQuery $recipeSearchQuery, SortQuery $sortQuery): BaseResponse {
        // Get the paginated recipes with filtering, sorting, and relations
        $paginator = $this->_recipeRepo->getRecipes($recipeSearchQuery, $sortQuery, $paginationQuery);

        // Map the recipes to the response format
        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);
        return new BaseResponse(true, 'Recipes retrieved successfully', 200, $paginatedRes);
    }

    public function getRecipeById(string $id): BaseResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients']);
        
        if (!$recipe) {
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        return new BaseResponse(true, 'Recipe retrieved successfully', 200, $recipe);
    }

    public function getDietaryPreferences(): array
    {
        return $this->_recipeRepo->getTagsByType(TagType::Dietary->value);
    }

    public function getCuisineTypes(): array
    {
        return $this->_recipeRepo->getTagsByType(TagType::Origin->value);
    }

    public function getCourses(): array
    {
        return $this->_recipeRepo->getTagsByType(TagType::Course->value);
    }

    public function getCookingMethods(): array
    {
        return $this->_recipeRepo->getTagsByType(TagType::CookingMethod->value);
    }

    public function getOccasions(): array
    {
        return $this->_recipeRepo->getTagsByType(TagType::Occasion->value);
    }
}
