<?php

namespace App\DTO\Responses;

use App\Models\Recipe;

class RecipeDetailedResponse
{
    private string $id;
    private string $name;
    private string|null $firstImageUrl;
    private string $description;
    private array $tags;
    private string $difficulty;
    private string $authorId;
    private string $createdAt;
    private string $updatedAt;
    private int $vote;
    private array $steps;
    private array $ingredients;
    private int $totalEstimatedTime;
    private array $imageUrls;

    public function __construct(
        Recipe $recipe,
        int $voteCount
    ) {
        $this->id = $recipe->id;
        $this->name = $recipe->name;
        $this->firstImageUrl = $recipe->first_image_url;
        $this->description = $recipe->description;
        $this->tags = $recipe->tags->map(function($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'type' => $tag->type->value ?? $tag->type,
            ];
        })->toArray();
        $this->difficulty = $recipe->difficulty->value;
        $this->authorId = $recipe->posted_by;
        $this->createdAt = $recipe->created_at;
        $this->updatedAt = $recipe->updated_at;
        $this->vote = $voteCount;
        $this->steps = $recipe->steps;
        $this->ingredients = $recipe->ingredients->map(function ($ingredient) {
            return new IngredientResponse($ingredient);
        })->toArray();
        $this->totalEstimatedTime = $recipe->total_estimated_time;
        $this->imageUrls = $recipe->image_urls;
    }

    // Getters for all properties
    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getFirstImageUrl(): string|null { return $this->firstImageUrl; }
    public function getDescription(): string { return $this->description; }
    public function getTags(): array { return $this->tags; }
    public function getDifficulty(): string { return $this->difficulty; }
    public function getAuthorId(): string { return $this->authorId; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }
    public function getVote(): int { return $this->vote; }
    public function getSteps(): array { return $this->steps; }
    public function getIngredients(): array { return $this->ingredients; }
    public function getTotalEstimatedTime(): int { return $this->totalEstimatedTime; }
    public function getImageUrls(): array { return $this->imageUrls; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_image_url' => $this->firstImageUrl,
            'description' => $this->description,
            'tags' => $this->tags,
            'difficulty' => $this->difficulty,
            'author_id' => $this->authorId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'vote' => $this->vote,
            'steps' => $this->steps,
            'ingredients' => array_map(fn($ingredient) => $ingredient->toArray(), $this->ingredients),
            'total_estimated_time' => $this->totalEstimatedTime,
            'image_urls' => $this->imageUrls,
        ];
    }

    // Magic method to allow property access for backward compatibility
    public function __get($property)
    {
        return match($property) {
            'id' => $this->id,
            'name' => $this->name,
            'firstImageUrl' => $this->firstImageUrl,
            'description' => $this->description,
            'tags' => $this->tags,
            'difficulty' => $this->difficulty,
            'authorId' => $this->authorId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'vote' => $this->vote,
            'steps' => $this->steps,
            'ingredients' => $this->ingredients,
            'totalEstimatedTime' => $this->totalEstimatedTime,
            'imageUrls' => $this->imageUrls,
            default => null,
        };
    }
}
