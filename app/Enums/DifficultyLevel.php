<?php

namespace App\Enums;

enum DifficultyLevel: string
{
    case Easy = 'easy';
    case Medium = 'medium';
    case Hard = 'hard';

    public function label(): string
    {
        return match ($this) {
            self::Easy => 'Easy',
            self::Medium => 'Medium',
            self::Hard => 'Hard',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_map(
            fn (self $case) => $case->label(),
            self::cases()
        );
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'easy' => self::Easy,
            'medium' => self::Medium,
            'hard' => self::Hard,
            default => throw new \InvalidArgumentException("Invalid difficulty level: $value"),
        };
    }
}
