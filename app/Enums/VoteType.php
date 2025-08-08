<?php

namespace App\Enums;

enum VoteType: string
{
    case UPVOTE = 'upvote';
    case DOWNVOTE = 'downvote';

    /**
     * Get all vote types as an array.
     */
    public static function toArray(): array
    {
        return [
            self::UPVOTE->value,
            self::DOWNVOTE->value,
        ];
    }

    /**
     * Get the opposite vote type.
     */
    public function opposite(): self
    {
        return match ($this) {
            self::UPVOTE => self::DOWNVOTE,
            self::DOWNVOTE => self::UPVOTE,
        };
    }

    /**
     * Check if this is an upvote.
     */
    public function isUpvote(): bool
    {
        return $this === self::UPVOTE;
    }

    /**
     * Check if this is a downvote.
     */
    public function isDownvote(): bool
    {
        return $this === self::DOWNVOTE;
    }
}
