<?php

namespace App\DTO\Responses;

class IngredientResponse
{
    public string $id;
    public string $name;
    public string $description;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
