<?php

namespace App\Enums;

class RecipePostStatus
{
    const DRAFT = 'draft';

    const APPROVED = 'approved';

    const REJECTED = 'rejected';

    const PENDING = 'pending';

    public static function values(): array
    {
        return [
            self::DRAFT,
            self::APPROVED,
            self::PENDING,
            self::REJECTED,
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

    public static function isApproved(string $status): bool
    {
        return $status === self::APPROVED;
    }

    public static function isDraft(string $status): bool
    {
        return $status === self::DRAFT;
    }
}
