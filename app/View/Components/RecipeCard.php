<?php

namespace App\View\Components;

use App\Models\Recipe;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeCard extends Component
{
    public Recipe $recipe;
    public bool $showVoting;
    public bool $showStats;
    public string $size;

    /**
     * Create a new component instance.
     *
     * @param Recipe $recipe The recipe model instance
     * @param bool $showVoting Whether to show voting buttons
     * @param bool $showStats Whether to show ingredient/steps stats
     * @param string $size Card size variant (small, medium, large)
     */
    public function __construct(
        Recipe $recipe,
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
     * TODO: Replace with actual vote count from database
     */
    public function getVoteCount(): int
    {
        // Temporary random vote count - replace with actual implementation
        return $this->recipe->vote_count ?? rand(10, 500);
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
        if ($this->recipe->image_urls && is_array($this->recipe->image_urls) && count($this->recipe->image_urls) > 0) {
            return $this->recipe->image_urls[0];
        }
        return null;
    }

    /**
     * Get the recipe author name
     */
    public function getAuthorName(): string
    {
        return $this->recipe->postedBy->name ?? 'Anonymous';
    }

    /**
     * Get the steps count
     */
    public function getStepsCount(): int
    {
        if (is_array($this->recipe->steps)) {
            return count($this->recipe->steps);
        }
        return 0;
    }

    /**
     * Get visible tags (limited to 3)
     */
    public function getVisibleTags()
    {
        return $this->recipe->tags->take(3);
    }

    /**
     * Get remaining tags count
     */
    public function getRemainingTagsCount(): int
    {
        $totalTags = $this->recipe->tags->count();
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
     * Get the view / template.
     */
    public function render(): View|Closure|string
    {
        return view('components.recipe-card');
    }
}
