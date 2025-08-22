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
    public Recipe|null $recipe = null;
    
    public function __construct()
    {
        $this->_recipeService = app(RecipeService::class);
    }

    public function mount(string $recipeId): void {
        $this->recipeId = $recipeId;
        $this->recipe = $this->getRecipe();
    }

    protected function getRecipe(): Recipe
    {
        return $this->_recipeService->getRecipeDetailsById($this->recipeId)->getData();
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
        $imageUrl = $this->getRecipe()->image_url;
        return !empty($imageUrl) ? $imageUrl : null;
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
        return view('recipes.recipe-card');
    }
}
