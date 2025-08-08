<?php

namespace App\DTO\Responses;

use App\Models\Ingredient;

class IngredientResponse
{
    private string $id;
    private string $name;
    private string $description;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        Ingredient $ingredient
    ) {
        $this->id = $ingredient->id;
        $this->name = $ingredient->name;
        $this->description = $ingredient->description;
        $this->createdAt = $ingredient->created_at;
        $this->updatedAt = $ingredient->updated_at;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
