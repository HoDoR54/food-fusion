<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Responses\BaseResponse;
use App\DTO\Responses\PaginatedResponse;
use App\Models\Recipe;
use Faker\Provider\Base;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

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

    public function getRecipeById(string $id): BaseResponse {
        $recipe = $this->_recipeRepo->findWithRelations($id, ['postedBy', 'tags', 'ingredients']);
        
        if (!$recipe) {
            return new BaseResponse(false, 'Recipe not found', 404);
        }

        $resData = [
            'recipe' => $recipe,
            'vote_count' => $this->_recipeRepo->countVotes($recipe->id),
        ];

        return new BaseResponse(true, 'Recipe retrieved successfully', 200, $resData);
    }

    public function upvoteRecipe(string $id): BaseResponse
    {
        $userId = Auth::id();
        if (!$userId) {
            return new BaseResponse(false, 'User not authenticated', 401);
        }

        if ($this->_recipeRepo->hasUserUpvoted($id, $userId)) {
            return new BaseResponse(false, 'User has already upvoted this recipe', 409);
        }

        $updatedVote = $this->_recipeRepo->upvoteRecipe($id, $userId);
        if (!$updatedVote) {
            return new BaseResponse(false, 'Failed to upvote recipe', 500);
        }
        return new BaseResponse(true, 'Recipe upvoted successfully', 200);
    }

    public function downvoteRecipe(string $id): BaseResponse
    {
        $userId = Auth::id();
        if (!$userId) {
            return new BaseResponse(false, 'User not authenticated', 401);
        }

        if ($this->_recipeRepo->hasUserDownvoted($id, $userId)) {
            return new BaseResponse(false, 'User has already downvoted this recipe', 409);
        }

        $updatedVote = $this->_recipeRepo->downvoteRecipe($id, $userId);
        if (!$updatedVote) {
            return new BaseResponse(false, 'Failed to downvote recipe', 500);
        }
        return new BaseResponse(true, 'Recipe downvoted successfully', 200);
    }

    public function getVoteCount(string $id): int
    {
        return $this->_recipeRepo->countVotes($id);
    }

    public function hasUserUpvoted(string $recipeId): BaseResponse
    {
        $userId = Auth::id();
        if (!$userId) {
            return new BaseResponse(false, 'User not authenticated', 401);
        }

        $hasUpvoted = $this->_recipeRepo->hasUserUpvoted($recipeId, $userId);
        return new BaseResponse(true, 'User has upvoted this recipe', 200, ['has_upvoted' => $hasUpvoted]);
    }

    public function hasUserDownvoted(string $recipeId): BaseResponse
    {
        $userId = Auth::id();
        if (!$userId) {
            return new BaseResponse(false, 'User not authenticated', 401);
        }

        $hasDownvoted = $this->_recipeRepo->hasUserDownvoted($recipeId, $userId);
        return new BaseResponse(true, 'User has downvoted this recipe', 200, ['has_downvoted' => $hasDownvoted]);
    }
}
