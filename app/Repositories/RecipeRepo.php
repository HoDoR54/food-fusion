<?php

namespace App\Repositories;

use App\Enums\VoteType;
use App\Models\Recipe;
use App\Models\RecipeVote;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo extends AbstractRepo
{
    public function __construct(Recipe $recipe) {
        parent::__construct($recipe);
    }

    public function countVotes (string $recipeId):int {
        return RecipeVote::where('recipe_id', $recipeId)->count();
    }

    public function upvoteRecipe (string $recipeId): int {
        // TO-DO: get user_id from auth
        // TO-DO: check if user has already voted to this recipe
        RecipeVote::updateOrCreate(
            ['recipe_id' => $recipeId, 'user_id' => '0198885d-2fb7-712a-8c09-3bb1c2e781af'],
            ['vote_type' => VoteType::UPVOTE]
        );

        return $this->countVotes($recipeId);
    }

    public function downvoteRecipe (string $recipeId): int {
        RecipeVote::updateOrCreate(
            ['recipe_id' => $recipeId, 'user_id' => '0198885d-2fb7-712a-8c09-3bb1c2e781af'],
            ['vote_type' => VoteType::DOWNVOTE]
        );

        return $this->countVotes($recipeId);
    }

    public function hasUserUpvoted (string $recipeId, string $userId): bool
    {
        return RecipeVote::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->where('vote_type', VoteType::UPVOTE)
            ->exists();
    }

    public function hasUserDownvoted (string $recipeId, string $userId): bool
    {
        return RecipeVote::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->where('vote_type', VoteType::DOWNVOTE)
            ->exists();
    }
}
