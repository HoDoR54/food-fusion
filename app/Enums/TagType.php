<?php 

namespace App\Enums;

enum TagType: string
{
    case Origin = 'origin';
    case Dietary = 'dietary';
    case Course = 'course';
    case CookingMethod = 'method';
    case Occasion = 'occasion';

    public static function labels(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Origin => 'Origin',
            self::Dietary => 'Dietary',
            self::Course => 'Course',
            self::CookingMethod => 'Cooking Method',
            self::Occasion => 'Occasion',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
?>
