<?php

namespace App\DTO\Requests;

class CreateIngredientRequest
{
    public string $name;
    public string $description;

    public function __construct(
        string $name,
        string $description
    ) {
        $this->name = $name;
        $this->description = $description;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
