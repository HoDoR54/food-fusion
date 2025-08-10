<?php

namespace App\Livewire;

use App\Enums\DifficultyLevel;
use App\Models\Recipe;
use App\Repositories\RecipeRepo;
use App\Services\RecipeService;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class RecipeCard extends Component
{
    protected RecipeService $_recipeService;

    public string $recipeId;
    
    protected ?Recipe $recipeCache = null;

    public function __construct()
    {
        $this->_recipeService = app(RecipeService::class);
    }

    public function mount(string $recipeId): void {
        $this->recipeId = $recipeId;
        // Don't preload the recipe - let it be loaded on demand
        $this->recipeCache = null;
    }

    // Add method to handle component hydration
    public function hydrate()
    {
        $this->_recipeService = app(RecipeService::class);
        // Clear cache on hydrate to ensure fresh data
        $this->recipeCache = null;
        
        // Debug logging to help identify issues
        Log::info('RecipeCard component hydrated', [
            'recipe_id' => $this->recipeId,
            'vote_count' => $this->voteCount,
            'component_id' => $this->getId()
        ]);
    }

    // Helper method to get the recipe
    protected function getRecipe(): Recipe
    {
        if (!$this->recipeCache) {
            $this->recipeCache = $this->_recipeService->getRecipeById($this->recipeId)->getData()['recipe'];
        }
        return $this->recipeCache;
    }

    public function getId(): string
    {
        return $this->recipeId;
    }

    public function getAuthorName(): ?string
    {
        return $this->getRecipe()->author_name;
    }

    public function getDifficultyColor(): string
    {
        return match($this->getRecipe()->difficulty->value) {
            'easy' => 'bg-green-500',
            'medium' => 'bg-yellow-500',
            'hard' => 'bg-red-500',
        };
    }

    public function getDifficultyIcon(): string
    {
        return match($this->getRecipe()->difficulty->value) {
            'easy' => 'fa-solid fa-leaf',
            'medium' => 'fa-solid fa-fire',
            'hard' => 'fa-solid fa-bolt',
            default => 'fa-solid fa-question',
        };
    }

    public function getDifficulty(): string
    {
        return $this->getRecipe()->difficulty->value;
    }

    public function getName (): string 
    {
        return $this->getRecipe()->name;
    }

    public function getDescription(): string
    {
        return $this->getRecipe()->description;
    }

    public function getPrimaryImageUrl(): ?string
    {
        return $this->getRecipe()->first_image_url;
    }

    public function getVisibleTags(): array
    {
        $tags = $this->getRecipe()->tags->toArray();
        $visibleTags = array_slice($tags, 0, 3);
        return array_map(fn($tag) => $tag['name'], $visibleTags);
    }

    public function getRemainingTagsCount(): int
    {
        return max(0, $this->getRecipe()->tags->count() - 3);
    }
    
    public function getFormattedCreatedAt(): string
    {
        try {
            return $this->getRecipe()->created_at->diffForHumans();
        } catch (\Exception $e) {
            return 'Recently';
        }
    }

    public function render()
    {
        return view('livewire.recipe-card');
    }
}
