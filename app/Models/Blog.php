<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'content', 'author_id', 'image_url'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('direction', 'up');
    }

    public function downvotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('direction', 'down');
    }

    public function getVoteScoreAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    public function getUserVote(string $userId): ?Vote
    {
        return $this->votes()->where('user_id', $userId)->first();
    }

    public function hasUserVoted(string $userId): bool
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    public function hasUserUpvoted(string $userId): bool
    {
        return $this->upvotes()->where('user_id', $userId)->exists();
    }

    public function hasUserDownvoted(string $userId): bool
    {
        return $this->downvotes()->where('user_id', $userId)->exists();
    }
}
