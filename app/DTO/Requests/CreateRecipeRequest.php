<?php

namespace App\DTO\Requests;

use App\Enums\DifficultyLevel;

class CreateRecipeRequest
{
    public string $name;
    public string $description;
    public array $steps;
    public DifficultyLevel $difficulty;
    public array $tagIds;
    public array $ingredientIds;
    public ?array $imageUrls;

    public function __construct(
        string $name,
        string $description,
        array $steps,
        DifficultyLevel $difficulty,
        array $tagIds = [],
        array $ingredientIds = [],
        ?array $imageUrls = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->steps = $steps;
        $this->difficulty = $difficulty;
        $this->tagIds = $tagIds;
        $this->ingredientIds = $ingredientIds;
        $this->imageUrls = $imageUrls;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            steps: array_map(fn($step) => RecipeStep::fromArray($step), $data['steps']),
            difficulty: DifficultyLevel::from($data['difficulty']),
            tagIds: $data['tag_ids'] ?? [],
            ingredientIds: $data['ingredient_ids'] ?? [],
            imageUrls: $data['image_urls'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'steps' => array_map(fn(RecipeStep $step) => $step->toArray(), $this->steps),
            'difficulty' => $this->difficulty->value,
            'tag_ids' => $this->tagIds,
            'ingredient_ids' => $this->ingredientIds,
            'image_urls' => $this->imageUrls,
        ];
    }
}
