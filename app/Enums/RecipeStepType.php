<?php

namespace App\Enums;

enum RecipeStepType: string
{
    case PREPARATION = 'preparation';
    case COOKING = 'cooking';
    case PLATING = 'plating';

    public function label(): string
    {
        return match ($this) {
            self::PREPARATION => 'Preparation',
            self::COOKING => 'Cooking',
            self::PLATING => 'Plating',
        };
    }

    public function value(): string
    {
        return $this->value;
    }

    public function values(): array
    {
        return [
            self::PREPARATION->value,
            self::COOKING->value,
            self::PLATING->value,
        ];
    }

    public function toArray(): array
    {
        return [
            'step_type' => $this->value,
            'label' => $this->label(),
        ];
    }
}
