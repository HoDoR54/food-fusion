<?php

namespace App\DTO\Responses;

use App\Enums\DifficultyLevel;

class RecipeSimpleResponse
{
    public string $id;
    public string $name;
    public string $firstImageUrl;
    public string $description;
    public array $tags;
    public DifficultyLevel $difficulty;
    public string $authorId;
    public string $authorName;
    public string $createdAt;
    public string $updatedAt;
    public int $vote;

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
        int $vote
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->firstImageUrl = $firstImageUrl;
        $this->description = $description;
        $this->tags = $tags;
        $this->difficulty = $difficulty;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->vote = $vote;
    }
}
