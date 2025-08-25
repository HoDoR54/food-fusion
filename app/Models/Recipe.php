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
        'image_url',
        'servings',
    ];

    protected $appends = [
        'author_name',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => DifficultyLevel::class,
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

    public function savedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_recipes')->withTimestamps();
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(RecipeAttempt::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient')
            ->withPivot(['amount', 'unit']);
    }

    public function getIngredientListAttribute(): array
    {
        return $this->ingredients->map(function ($ingredient) {
            $name = $ingredient->name;
            $amount = $ingredient->pivot->amount;
            $unit = $ingredient->pivot->unit;

            return "{$amount} {$unit} of {$name}";
        })->toArray();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->attributes['image_url'] ?? null;
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
