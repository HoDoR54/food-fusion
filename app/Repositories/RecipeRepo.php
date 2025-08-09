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

    public function upvoteRecipe (string $recipeId, string $userId): int {
        RecipeVote::updateOrCreate(
            ['recipe_id' => $recipeId, 'user_id' => $userId],
            ['vote_type' => VoteType::UPVOTE]
        );

        return $this->countVotes($recipeId);
    }

    public function downvoteRecipe (string $recipeId, string $userId): int {
        RecipeVote::updateOrCreate(
            ['recipe_id' => $recipeId, 'user_id' => $userId],
            ['vote_type' => VoteType::DOWNVOTE]
        );

        return $this->countVotes($recipeId);
    }

    public function hasUserUpvoted(string $recipeId, string $userId): bool
    {
        $lastVote = RecipeVote::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->first();

        if (!$lastVote) {
            return false;
        }

        return $lastVote->vote_type === VoteType::UPVOTE;
    }


    public function hasUserDownvoted (string $recipeId, string $userId): bool
    {
        $lastVote = RecipeVote::where('recipe_id', $recipeId)
            ->where('user_id', $userId)
            ->orderByDesc('created_at') // or 'id' if votes increment
            ->first();

        if (!$lastVote) {
            return false; // no votes at all
        }

        return $lastVote->vote_type === VoteType::DOWNVOTE;
    }
}