<?php

namespace App\Enums;

enum ButtonVariant: string
{
    case Primary = 'primary';
    case Secondary = 'secondary';

    public function label(): string
    {
        return match ($this) {
            self::Primary => 'Primary',
            self::Secondary => 'Secondary',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_map(
            fn(self $case) => $case->label(),
            self::cases()
        );
    }
}
