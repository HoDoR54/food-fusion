<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Responses\PaginatedResponse;
use App\DTO\Responses\RecipeDetailedResponse;
use App\DTO\Responses\RecipeSimpleResponse;
use App\Models\Recipe;

class RecipeService
{
    protected RecipeRepo $_recipeRepo;

    public function __construct(RecipeRepo $recipeRepo) {
        $this->_recipeRepo = $recipeRepo;
    }

    public function getRecipes(PaginationQuery $paginationQuery): PaginatedResponse {
        $paginator = $this->_recipeRepo->paginateWithRelations(
            $paginationQuery->getPage(), 
            ['*'], 
            $paginationQuery->getSize(),
            ['postedBy', 'tags']
        );
        
        $transformedData = $paginator->getCollection()->map(function (Recipe $recipe) {
            return new RecipeSimpleResponse(
                id: $recipe->id,
                name: $recipe->name,
                firstImageUrl: $recipe->image_urls ? $recipe->image_urls[0] ?? '' : '',
                description: $recipe->description,
                tags: $recipe->tags->map(fn($tag) => $tag->name)->toArray(),
                difficulty: $recipe->difficulty,
                authorId: $recipe->posted_by,
                authorName: $recipe->postedBy->name ?? 'Unknown',
                createdAt: $recipe->created_at->toISOString(),
                updatedAt: $recipe->updated_at->toISOString(),
                vote: 0
            );
        })->toArray();

        return PaginatedResponse::fromPaginator($paginator, $transformedData);
    }

    public function getRecipeById(string $id): ?RecipeDetailedResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients']);
        
        if (!$recipe) {
            return null;
        }

        return new RecipeDetailedResponse(
            id: $recipe->id,
            name: $recipe->name,
            firstImageUrl: $recipe->image_urls ? $recipe->image_urls[0] ?? '' : '',
            description: $recipe->description,
            tags: $recipe->tags->map(fn($tag) => $tag->name)->toArray(),
            difficulty: $recipe->difficulty,
            authorId: $recipe->posted_by,
            authorName: $recipe->postedBy->name ?? 'Unknown',
            createdAt: $recipe->created_at->toISOString(),
            updatedAt: $recipe->updated_at->toISOString(),
            vote: 0, // TODO: Implement voting feature
            steps: $recipe->steps,
            ingredients: $recipe->ingredients->map(fn($ingredient) => $ingredient->name)->toArray(),
            totalEstimatedTime: collect($recipe->steps)->sum('estimated_time_taken'),
            imageUrls: $recipe->image_urls ?? []
        );
    }
}
