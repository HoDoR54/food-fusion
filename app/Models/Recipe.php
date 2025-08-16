<?php

namespace App\Models;

use App\Casts\RecipeStepsCast;
use App\Enums\DifficultyLevel;
use App\Enums\RecipeStepType;
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
        'approved_by',
        'approved_at',
        'name',
        'description',
        'steps',
        'difficulty',
        'image_urls',
    ];

    protected $appends = [
        'first_image_url',
        'author_name',
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

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(RecipeAttempt::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag');
    }

    public function getFirstImageUrlAttribute(): ?string
    {
        return is_array($this->image_urls) && count($this->image_urls) > 0 
            ? $this->image_urls[0] 
            : null;
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->postedBy?->name ?? 'Unknown';
    }

    public function getDifficultyValueAttribute(): string
    {
        return $this->difficulty->value;
    }

    public function getPreparationMinutes(): int
    {
        return $this->steps
            ->where('stepType', RecipeStepType::PREPARATION)
            ->sum('estimated_minutes_taken');
    }

    public function getTotalCookingMinutes(): int
    {
        return $this->steps
            ->where('stepType', RecipeStepType::COOKING)
            ->sum('estimated_minutes_taken');
    }

    public function getTotalPlatingMinutes(): int
    {
        return $this->steps
            ->where('stepType', RecipeStepType::PLATING)
            ->sum('estimated_minutes_taken');
    }

    public function getTotalMinutes(): int
    {
        return $this->getPreparationMinutes()
            + $this->getTotalCookingMinutes()
            + $this->getTotalPlatingMinutes();
    }
}
