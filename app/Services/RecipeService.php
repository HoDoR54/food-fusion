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

    public function getRecipeDetailsById(string $id): BaseResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients', 'attempts']);

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

    public function storeRecipe(array $data, ?string $userId = null): BaseResponse
    {
        try {
            \DB::beginTransaction();

            // Handle image upload if present
            $imageUrl = null;
            if (isset($data['image']) && $data['image']) {
                $imageUrl = $this->uploadRecipeImage($data['image']);
            }

            // Create the recipe
            $recipe = Recipe::create([
                'posted_by' => $userId,
                'name' => $data['name'],
                'description' => $data['description'],
                'servings' => $data['servings'],
                'difficulty' => $data['difficulty'],
                'image_url' => $imageUrl,
                'steps' => $data['steps'],
            ]);

            // Handle ingredients
            if (isset($data['ingredients'])) {
                $this->attachIngredients($recipe, $data['ingredients']);
            }

            // Handle tags
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
        // This is a placeholder - implement your image upload logic here
        // You might want to use Cloudinary, S3, or local storage
        $path = $image->store('recipes', 'public');
        return asset('storage/' . $path);
    }

    private function attachIngredients(Recipe $recipe, array $ingredients): void
    {
        foreach ($ingredients as $ingredientData) {
            // Find or create ingredient
            $ingredient = \App\Models\Ingredient::firstOrCreate(
                ['name' => $ingredientData['name']],
                ['description' => ''] // Default empty description
            );

            // Attach to recipe with pivot data
            $recipe->ingredients()->attach($ingredient->id, [
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

            // Find or create tag
            $tag = \App\Models\Tag::firstOrCreate(
                ['name' => strtolower(trim($tagData['name']))],
                ['type' => $tagData['type']]
            );

            $tagIds[] = $tag->id;
        }

        if (!empty($tagIds)) {
            $recipe->tags()->attach($tagIds);
        }
    }
}
