<?php

namespace App\Livewire;

use App\Enums\DifficultyLevel;
use App\Models\Recipe;
use App\Repositories\RecipeRepo;
use App\Services\RecipeService;
use Carbon\Carbon;
use Livewire\Component;

class RecipeCard extends Component
{
    protected RecipeService $_recipeService;

    public Recipe $recipe;
    public int $voteCount;

    public function __construct()
    {
        $this->_recipeService = app(RecipeService::class);
    }

    public function mount(Recipe $recipe, int $voteCount): void {
        $this->recipe = $recipe;
        $this->voteCount = $voteCount;
    }

    public function getId(): string
    {
        return $this->recipe->id;
    }

    public function getAuthorName(): ?string
    {
        return $this->recipe->author_name;
    }

    public function getVoteCount(): int
    {
        return $this->recipe->vote_count ?? $this->_recipeService->getVoteCount($this->recipe->id);
    }

    public function getDifficultyColor(): string
    {
        return match($this->recipe->difficulty->value) {
            'easy' => 'bg-green-500',
            'medium' => 'bg-yellow-500',
            'hard' => 'bg-red-500',
        };
    }

    public function getDifficultyIcon(): string
    {
        return match($this->recipe->difficulty->value) {
            'easy' => 'fa-solid fa-leaf',
            'medium' => 'fa-solid fa-fire',
            'hard' => 'fa-solid fa-bolt',
            default => 'fa-solid fa-question',
        };
    }

    public function getDifficulty(): string
    {
        return $this->recipe->difficulty->value;
    }

    public function getName (): string 
    {
        return $this->recipe->name;
    }

    public function getDescription(): string
    {
        return $this->recipe->description;
    }

    public function getPrimaryImageUrl(): ?string
    {
        return $this->recipe->first_image_url;
    }

    public function getVisibleTags(): array
    {
        $tags = $this->recipe->tags->toArray();
        $visibleTags = array_slice($tags, 0, 3);
        return array_map(fn($tag) => $tag['name'], $visibleTags);
    }

    public function getRemainingTagsCount(): int
    {
        return max(0, $this->recipe->tags->count() - 3);
    }

    public function upvoteRecipe(string $id): void
    {
        $this->_recipeService->upvoteRecipe($id);
    }

    public function downvoteRecipe(string $id): void
    {
        $this->_recipeService->downvoteRecipe($id);
    }
    
    public function getFormattedCreatedAt(): string
    {
        try {
            return $this->recipe->created_at->diffForHumans();
        } catch (\Exception $e) {
            return 'Recently';
        }
    }

    public function hasUserUpvoted(): bool
    {
        return $this->_recipeService->hasUserUpvoted($this->recipe->id);
    }

    public function hasUserDownvoted(): bool
    {
        return $this->_recipeService->hasUserDownvoted($this->recipe->id);
    }

    public function render()
    {
        return view('livewire.recipe-card');
    }
}
