<?php

namespace App\DTO\Responses;

use App\Enums\TagType;
use App\Models\Tag;

class TagResponse
{
    private string $id;
    private string $name;
    private string $type;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        Tag $tag
    ) {
        $this->id = $tag->id;
        $this->name = $tag->name;
        $this->type = $tag->type->value;
        $this->createdAt = $tag->created_at;
        $this->updatedAt = $tag->updated_at;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
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
            'type' => $this->type,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    // Magic method to allow property access for backward compatibility
    public function __get($property)
    {
        return match($property) {
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            default => null,
        };
    }
}
