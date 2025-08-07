<?php

namespace App\DTO\Responses;

use App\Enums\TagType;

class TagResponse
{
    public string $id;
    public string $name;
    public TagType $type;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        TagType $type,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
