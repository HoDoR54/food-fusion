<?php

namespace App\DTO\Responses;

use App\Enums\DifficultyLevel;
use App\Models\Recipe;

class RecipeSimpleResponse
{
    private string $id;
    private string $name;
    private string|null $firstImageUrl;
    private string $description;
    private array $tags;
    private string $difficulty;
    private string $authorId;
    private string $authorName;
    private string $createdAt;
    private string $updatedAt;
    private int $vote;

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
        $this->authorName = $recipe->postedBy ? $recipe->postedBy->name : 'Unknown';
        $this->createdAt = $recipe->created_at;
        $this->updatedAt = $recipe->updated_at;
        $this->vote = $voteCount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstImageUrl(): string
    {
        return $this->firstImageUrl;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getDifficulty(): string
    {
        return $this->difficulty;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getVote(): int
    {
        return $this->vote;
    }

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
            'author_name' => $this->authorName,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'vote' => $this->vote,
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
            'authorName' => $this->authorName,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'vote' => $this->vote,
            default => null,
        };
    }
}
