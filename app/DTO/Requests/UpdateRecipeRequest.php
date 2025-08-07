<?php

namespace App\DTO\Requests;

use App\Enums\DifficultyLevel;

class UpdateRecipeRequest
{
    public ?string $name;
    public ?string $description;
    public ?array $steps;
    public ?DifficultyLevel $difficulty;
    public ?array $tagIds;
    public ?array $ingredientIds;
    public ?array $imageUrls;

    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?array $steps = null,
        ?DifficultyLevel $difficulty = null,
        ?array $tagIds = null,
        ?array $ingredientIds = null,
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
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            steps: isset($data['steps']) ? array_map(fn($step) => RecipeStep::fromArray($step), $data['steps']) : null,
            difficulty: isset($data['difficulty']) ? DifficultyLevel::from($data['difficulty']) : null,
            tagIds: $data['tag_ids'] ?? null,
            ingredientIds: $data['ingredient_ids'] ?? null,
            imageUrls: $data['image_urls'] ?? null
        );
    }

    public function toArray(): array
    {
        $result = [];
        
        if ($this->name !== null) {
            $result['name'] = $this->name;
        }
        
        if ($this->description !== null) {
            $result['description'] = $this->description;
        }
        
        if ($this->steps !== null) {
            $result['steps'] = array_map(fn(RecipeStep $step) => $step->toArray(), $this->steps);
        }
        
        if ($this->difficulty !== null) {
            $result['difficulty'] = $this->difficulty->value;
        }
        
        if ($this->tagIds !== null) {
            $result['tag_ids'] = $this->tagIds;
        }
        
        if ($this->ingredientIds !== null) {
            $result['ingredient_ids'] = $this->ingredientIds;
        }
        
        if ($this->imageUrls !== null) {
            $result['image_urls'] = $this->imageUrls;
        }
        
        return $result;
    }

    public function hasChanges(): bool
    {
        return $this->name !== null
            || $this->description !== null
            || $this->steps !== null
            || $this->difficulty !== null
            || $this->tagIds !== null
            || $this->ingredientIds !== null
            || $this->imageUrls !== null;
    }
}
