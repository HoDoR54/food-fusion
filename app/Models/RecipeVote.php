<?php

namespace App\Models;

use App\Enums\VoteType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeVote extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'recipe_id',
        'user_id',
        'vote_type',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipe_votes';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vote_type' => VoteType::class,
        ];
    }

    /**
     * Get the recipe that this vote belongs to.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Get the user who cast this vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is an upvote.
     */
    public function isUpvote(): bool
    {
        return $this->vote_type === VoteType::UPVOTE;
    }

    /**
     * Check if this is a downvote.
     */
    public function isDownvote(): bool
    {
        return $this->vote_type === VoteType::DOWNVOTE;
    }

    /**
     * Scope to get only upvotes.
     */
    public function scopeUpvotes($query)
    {
        return $query->where('vote_type', VoteType::UPVOTE);
    }

    /**
     * Scope to get only downvotes.
     */
    public function scopeDownvotes($query)
    {
        return $query->where('vote_type', VoteType::DOWNVOTE);
    }
}
