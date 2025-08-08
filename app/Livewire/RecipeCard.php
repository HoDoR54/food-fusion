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

    private string $recipeId;
    private string $name;
    private string $description;
    private ?string $imageUrl;
    private array $tags;
    private string $difficulty;
    private string $createdAt;
    private ?string $authorName;

    public function __construct()
    {
        $this->_recipeService = app(RecipeService::class);
    }

    public function mount(
        string $recipeId,
        string $name,
        string $description,
        ?string $imageUrl,
        array $tags,
        string $difficulty,
        string $createdAt,
        ?string $authorName = null,
    ): void {
        $this->recipeId = $recipeId;
        $this->name = $name;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->tags = $tags;
        $this->difficulty = $difficulty;
        $this->createdAt = $createdAt;
        $this->authorName = $authorName;
    }

    public function getId(): string
    {
        return $this->recipeId;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function getVoteCount(): int
    {
        return $this->_recipeService->getVoteCount($this->recipeId);
    }

    public function getDifficultyColor(): string
    {
        return match($this->difficulty) {
            'easy' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'hard' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getDifficultyIcon(): string
    {
        return match($this->difficulty) {
            'easy' => 'fa-solid fa-leaf',
            'medium' => 'fa-solid fa-fire',
            'hard' => 'fa-solid fa-bolt',
            default => 'fa-solid fa-question',
        };
    }

    public function getName (): string 
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrimaryImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getVisibleTags(): array
    {
        $visibleTags = array_slice($this->tags, 0, 3);
        return array_map(fn($tag) => $tag['name'], $visibleTags);
    }

    public function getRemainingTagsCount(): int
    {
        return max(0, count($this->tags) - 3);
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
            return Carbon::parse($this->createdAt)->diffForHumans();
        } catch (\Exception $e) {
            return 'Recently';
        }
    }

    public function hasUserUpvoted(): bool
    {
        return $this->_recipeService->hasUserUpvoted($this->recipeId);
    }

    public function hasUserDownvoted(): bool
    {
        return $this->_recipeService->hasUserDownvoted($this->recipeId);
    }

    public function render()
    {
        return view('livewire.recipe-card');
    }
}
