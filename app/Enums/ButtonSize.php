<?php

namespace App\Enums;

enum ButtonSize: string
{
    case Small = 'sm';
    case Medium = 'md';
    case Large = 'lg';

    public function label(): string
    {
        return match ($this) {
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
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
}
