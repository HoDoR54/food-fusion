<?php

namespace App\Enums;

enum ContactFormSubmissionType: string
{
    case General = 'general';
    case Enquiry = 'enquiry';
    case Feedback = 'feedback';
    case RecipeRequest = 'recipe_request';

    public function label(): string
    {
        return match ($this) {
            self::General => 'General Inquiry',
            self::Enquiry => 'Specific Inquiry',
            self::Feedback => 'Feedback',
            self::RecipeRequest => 'Recipe Request',
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
            'general' => self::General,
            'enquiry' => self::Enquiry,
            'feedback' => self::Feedback,
            'recipe_request' => self::RecipeRequest,
            default => throw new \InvalidArgumentException("Invalid contact form submission type: $value"),
        };
    }
}
