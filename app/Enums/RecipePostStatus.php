<?php

namespace App\Enums;

class RecipePostStatus
{
    const DRAFT = 'draft';
    const CURATED = 'curated';
    const REJECTED = 'rejected';
    const PENDING = 'pending';

    public static function values(): array
    {
        return [
            self::DRAFT,
            self::CURATED,
            self::PENDING,
        ];
    }

    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::values(), true);
    }

    public static function isRejected(string $status): bool
    {
        return $status === self::REJECTED;
    }

    public static function isPending(string $status): bool
    {
        return $status === self::PENDING;
    }

    public static function isCurated(string $status): bool
    {
        return $status === self::CURATED;
    }

    public static function isDraft(string $status): bool
    {
        return $status === self::DRAFT;
    }
}
