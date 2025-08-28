<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'blog_id',
        'direction',
    ];

    protected $casts = [
        'direction' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function isUpvote(): bool
    {
        return $this->direction === 'up';
    }

    public function isDownvote(): bool
    {
        return $this->direction === 'down';
    }
}
