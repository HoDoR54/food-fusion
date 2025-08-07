<?php

namespace App\View\Components;

use App\DTO\Responses\RecipeSimpleResponse;
use App\Models\Recipe;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeCard extends Component
{
    public RecipeSimpleResponse $recipe;
    public bool $showVoting;
    public bool $showStats;
    public string $size;

    /**
     * Create a new component instance.
     *
     * @param RecipeSimpleResponse $recipe The recipe DTO instance
     * @param bool $showVoting Whether to show voting buttons
     * @param bool $showStats Whether to show ingredient/steps stats
     * @param string $size Card size variant (small, medium, large)
     */
    public function __construct(
        RecipeSimpleResponse $recipe,
        bool $showVoting = true,
        bool $showStats = true,
        string $size = 'medium'
    ) {
        $this->recipe = $recipe;
        $this->showVoting = $showVoting;
        $this->showStats = $showStats;
        $this->size = $size;
    }

    /**
     * Get the vote count for display
     */
    public function getVoteCount(): int
    {
        return $this->recipe->vote;
    }

    /**
     * Get the difficulty badge color class
     */
    public function getDifficultyBadgeColor(): string
    {
        return match($this->recipe->difficulty->value) {
            'easy' => 'bg-green-500',
            'medium' => 'bg-yellow-500',
            'hard' => 'bg-red-500',
            default => 'bg-gray-500'
        };
    }

    /**
     * Get the primary image URL or null if no images
     */
    public function getPrimaryImageUrl(): ?string
    {
        return $this->recipe->firstImageUrl ?: null;
    }

    /**
     * Get the recipe author name
     */
    public function getAuthorName(): string
    {
        return $this->recipe->authorName;
    }

    /**
     * Get the steps count - not available in simple response
     */
    public function getStepsCount(): int
    {
        // Steps are not available in RecipeSimpleResponse
        return 0;
    }

    /**
     * Get visible tags (limited to 3)
     */
    public function getVisibleTags(): array
    {
        return array_slice($this->recipe->tags, 0, 3);
    }

    /**
     * Get remaining tags count
     */
    public function getRemainingTagsCount(): int
    {
        $totalTags = count($this->recipe->tags);
        return max(0, $totalTags - 3);
    }

    /**
     * Check if user has upvoted this recipe
     * TODO: Implement actual user vote checking
     */
    public function hasUserUpvoted(): bool
    {
        // TODO: Check against authenticated user's votes
        return false;
    }

    /**
     * Check if user has downvoted this recipe
     * TODO: Implement actual user vote checking
     */
    public function hasUserDownvoted(): bool
    {
        // TODO: Check against authenticated user's votes
        return false;
    }

    /**
     * Get the CSS classes for the card size
     */
    public function getCardSizeClasses(): string
    {
        return match($this->size) {
            'small' => 'text-sm',
            'large' => 'text-lg',
            default => 'text-base'
        };
    }

    /**
     * Get formatted creation date
     */
    public function getFormattedCreatedAt(): string
    {
        try {
            return Carbon::parse($this->recipe->createdAt)->diffForHumans();
        } catch (\Exception $e) {
            return 'Recently';
        }
    }

    /**
     * Get the view / template.
     */
    public function render(): View|Closure|string
    {
        return view('components.recipe-card');
    }
}
