<?php

namespace App\DTO\Requests;

use App\Enums\TagType;

class CreateTagRequest
{
    public string $name;
    public TagType $type;

    public function __construct(
        string $name,
        TagType $type
    ) {
        $this->name = $name;
        $this->type = $type;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            type: TagType::from($data['type'])
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
        ];
    }
}
