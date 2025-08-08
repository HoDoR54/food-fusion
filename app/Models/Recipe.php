<?php

namespace App\Models;

use App\Casts\RecipeStepsCast;
use App\Enums\DifficultyLevel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'posted_by',
        'name',
        'description',
        'steps',
        'difficulty',
        'image_urls',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => DifficultyLevel::class,
            'image_urls' => 'array',
            'steps' => RecipeStepsCast::class,
        ];
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipes_ingredients_joint');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipes_tags_joint');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(RecipeVote::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->upvotes();
    }

    public function downvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->downvotes();
    }

    public function getVoteScoreAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }
}
