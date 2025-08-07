<?php

namespace App\DTO\Responses;

use App\Enums\DifficultyLevel;

class RecipeDetailedResponse extends RecipeSimpleResponse
{
    public array $steps;
    public array $ingredients;
    public int $totalEstimatedTime;
    public array $imageUrls;

    public function __construct(
        string $id,
        string $name,
        string $firstImageUrl,
        string $description,
        array $tags,
        DifficultyLevel $difficulty,
        string $authorId,
        string $authorName,
        string $createdAt,
        string $updatedAt,
        int $vote,
        array $steps,
        array $ingredients,
        int $totalEstimatedTime,
        array $imageUrls
    ) {
        parent::__construct(
            $id,
            $name,
            $firstImageUrl,
            $description,
            $tags,
            $difficulty,
            $authorId,
            $authorName,
            $createdAt,
            $updatedAt,
            $vote
        );
        $this->steps = $steps;
        $this->ingredients = $ingredients;
        $this->totalEstimatedTime = $totalEstimatedTime;
        $this->imageUrls = $imageUrls;
    }
}
