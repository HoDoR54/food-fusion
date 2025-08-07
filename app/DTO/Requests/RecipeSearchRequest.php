<?php

namespace App\DTO\Requests;

use App\Enums\DifficultyLevel;
use App\Enums\TagType;

class RecipeSearchRequest
{
    public ?string $query;
    public ?DifficultyLevel $difficulty;
    public ?array $tagIds;
    public ?TagType $tagType;
    public ?array $ingredientIds;
    public ?string $authorId;
    public ?string $sortBy;
    public ?string $sortDirection;
    public int $page;
    public int $size;

    public function __construct(
        ?string $query = null,
        ?DifficultyLevel $difficulty = null,
        ?array $tagIds = null,
        ?TagType $tagType = null,
        ?array $ingredientIds = null,
        ?string $authorId = null,
        ?string $sortBy = 'created_at',
        ?string $sortDirection = 'desc',
        int $page = 1,
        int $size = 10
    ) {
        $this->query = $query;
        $this->difficulty = $difficulty;
        $this->tagIds = $tagIds;
        $this->tagType = $tagType;
        $this->ingredientIds = $ingredientIds;
        $this->authorId = $authorId;
        $this->sortBy = $sortBy ?? 'created_at';
        $this->sortDirection = $sortDirection ?? 'desc';
        $this->page = max(1, $page);
        $this->size = min(100, max(1, $size));
    }

    public static function fromArray(array $data): self
    {
        return new self(
            query: $data['query'] ?? null,
            difficulty: isset($data['difficulty']) ? DifficultyLevel::from($data['difficulty']) : null,
            tagIds: $data['tag_ids'] ?? null,
            tagType: isset($data['tag_type']) ? TagType::from($data['tag_type']) : null,
            ingredientIds: $data['ingredient_ids'] ?? null,
            authorId: $data['author_id'] ?? null,
            sortBy: $data['sort_by'] ?? 'created_at',
            sortDirection: $data['sort_direction'] ?? 'desc',
            page: (int) ($data['page'] ?? 1),
            size: (int) ($data['size'] ?? 10)
        );
    }

    public function toArray(): array
    {
        $result = [
            'page' => $this->page,
            'size' => $this->size,
            'sort_by' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
        ];

        if ($this->query !== null) {
            $result['query'] = $this->query;
        }

        if ($this->difficulty !== null) {
            $result['difficulty'] = $this->difficulty->value;
        }

        if ($this->tagIds !== null) {
            $result['tag_ids'] = $this->tagIds;
        }

        if ($this->tagType !== null) {
            $result['tag_type'] = $this->tagType->value;
        }

        if ($this->ingredientIds !== null) {
            $result['ingredient_ids'] = $this->ingredientIds;
        }

        if ($this->authorId !== null) {
            $result['author_id'] = $this->authorId;
        }

        return $result;
    }

    public function hasFilters(): bool
    {
        return $this->query !== null
            || $this->difficulty !== null
            || $this->tagIds !== null
            || $this->tagType !== null
            || $this->ingredientIds !== null
            || $this->authorId !== null;
    }
}
