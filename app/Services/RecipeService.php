<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        
        $resData = $paginator->getCollection()->map(function (Recipe $recipe) {
            $voteCount = $this->_recipeRepo->countVotes($recipe->id);
            return ['recipe' => $recipe, 'vote_count' => $voteCount];
        })->toArray();

        return PaginatedResponse::fromPaginator($paginator, $resData);
    }

    public function getRecipeById(string $id): ?Recipe {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients']);
        
        if (!$recipe) {
            return null;
        }

        // Add vote count as a dynamic attribute
        $recipe->vote_count = $this->_recipeRepo->countVotes($recipe->id);

        return $recipe;
    }

    public function upvoteRecipe(string $id): int
    {
        return $this->_recipeRepo->upvoteRecipe($id);
    }

    public function downvoteRecipe(string $id): int
    {
        return $this->_recipeRepo->downvoteRecipe($id);
    }

    public function getVoteCount(string $id): int
    {
        return $this->_recipeRepo->countVotes($id);
    }

    public function hasUserUpvoted(string $recipeId): bool
    {
        // TO-DO: get userId from auth
        return $this->_recipeRepo->hasUserUpvoted($recipeId, 'abc');
    }

    public function hasUserDownvoted(string $recipeId): bool
    {
        return $this->_recipeRepo->hasUserDownvoted($recipeId, 'abc');
    }
}
