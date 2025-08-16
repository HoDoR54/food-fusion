<?php

namespace App\DTO\Requests;

use App\Enums\RecipeStepType;

class RecipeStep
{
    public function __construct(
        public readonly int $order,
        public readonly string $description,
        public readonly RecipeStepType $stepType,
        public readonly int $estimated_minutes_taken,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            order: $data['order'],
            description: $data['description'],
            stepType: RecipeStepType::from($data['step_type']),
            estimated_minutes_taken: $data['estimated_time_taken'],
        );
    }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'order' => $this->order,
            'description' => $this->description,
            'step_type' => $this->stepType->value,
            'estimated_time_taken' => $this->estimated_minutes_taken,
        ];
    }

    /**
     * Convert to JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
