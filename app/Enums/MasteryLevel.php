<?php

namespace App\Enums;

enum MasteryLevel: string {
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    public function label(): string
    {
        return match($this) {
            self::BEGINNER => 'Beginner',
            self::INTERMEDIATE => 'Intermediate',
            self::ADVANCED => 'Advanced',
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

    public static function toEnum(string $value): ?MasteryLevel
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

}
?>

