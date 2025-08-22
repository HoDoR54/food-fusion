<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\Repositories\IngredientRepo;
use App\Repositories\TagRepo;
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
    protected IngredientRepo $_ingredientRepo;
    protected TagRepo $_tagRepo;

    public function __construct(RecipeRepo $recipeRepo, IngredientRepo $ingredientRepo, TagRepo $tagRepo) {
        $this->_recipeRepo = $recipeRepo;
        $this->_ingredientRepo = $ingredientRepo;
        $this->_tagRepo = $tagRepo;
    }

    public function getRecipes(PaginationQuery $paginationQuery, RecipeSearchQuery $recipeSearchQuery, SortQuery $sortQuery): BaseResponse {
        $paginator = $this->_recipeRepo->getRecipes($recipeSearchQuery, $sortQuery, $paginationQuery);

        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);
        return new BaseResponse(true, 'Recipes retrieved successfully', 200, $paginatedRes);
    }

    public function getApprovedRecipes(PaginationQuery $paginationQuery, RecipeSearchQuery $recipeSearchQuery, SortQuery $sortQuery): BaseResponse {
        $paginator = $this->_recipeRepo->getApprovedRecipes($recipeSearchQuery, $sortQuery, $paginationQuery);

        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return ['recipe' => $recipe];
        })->toArray();

        $paginatedRes = PaginatedResponse::fromPaginator($paginator, $resData);
        return new BaseResponse(true, 'Approved recipes retrieved successfully', 200, $paginatedRes);
    }

    public function getRecipeDetailsById(string $id): BaseResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients', 'attempts']);

        if (!$recipe) {
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        return new BaseResponse(true, 'Recipe retrieved successfully', 200, $recipe);
    }

    public function getDietaryPreferences(): array
    {
        return $this->_tagRepo->getByType(TagType::Dietary->value);
    }

    public function getCuisineTypes(): array
    {
        return $this->_tagRepo->getByType(TagType::Origin->value);
    }

    public function getCourses(): array
    {
        return $this->_tagRepo->getByType(TagType::Course->value);
    }

    public function getCookingMethods(): array
    {
        return $this->_tagRepo->getByType(TagType::CookingMethod->value);
    }

    public function getOccasions(): array
    {
        return $this->_tagRepo->getByType(TagType::Occasion->value);
    }

    public function storeRecipe(array $data, ?string $userId = null, ?string $imageUrl = null): BaseResponse
    {
        try {
            \DB::beginTransaction();

            $recipe = $this->_recipeRepo->create([
                'posted_by' => $userId,
                'name' => $data['name'],
                'description' => $data['description'],
                'servings' => $data['servings'],
                'difficulty' => $data['difficulty'],
                'image_url' => $imageUrl,
                'steps' => $data['steps'],
            ]);

            // attach ingredients and tags
            if (isset($data['ingredients'])) {
                $this->attachIngredients($recipe, $data['ingredients']);
            }
            if (isset($data['tags'])) {
                $this->attachTags($recipe, $data['tags']);
            }

            \DB::commit();

            return new BaseResponse(true, 'Recipe created successfully! It will be reviewed before publication.', 201, $recipe);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error creating recipe: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return new BaseResponse(false, 'Failed to create recipe. Please try again.', 500);
        }
    }

    private function uploadRecipeImage($image): ?string
    {
        $path = $image->store('recipes', 'public');
        return asset('storage/' . $path);
    }

    private function attachIngredients(Recipe $recipe, array $ingredients): void
    {
        foreach ($ingredients as $ingredientData) {
            // Find or create ingredient using repository
            $ingredient = $this->_ingredientRepo->findOrCreateByName(
                $ingredientData['name'],
                '' // Default empty description
            );

            // Attach to recipe with pivot data using repository
            $this->_recipeRepo->attachIngredient($recipe, $ingredient->id, [
                'amount' => $ingredientData['amount'],
                'unit' => $ingredientData['unit'],
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

            // Find or create tag using repository
            $tag = $this->_tagRepo->findOrCreateByNameAndType(
                $tagData['name'],
                $tagData['type']
            );

            $tagIds[] = $tag->id;
        }

        // Attach tags using repository
        $this->_recipeRepo->attachTags($recipe, $tagIds);
    }
}
