<?php

namespace App\Models;

use App\Casts\RecipeStepsCast;
use App\Enums\DifficultyLevel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'posted_by',
        'name',
        'description',
        'steps',
        'difficulty',
        'image_urls',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'difficulty' => DifficultyLevel::class,
            'image_urls' => 'array',
            'steps' => RecipeStepsCast::class,
        ];
    }

    /**
     * Get the user who posted this recipe.
     */
    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * The ingredients that belong to the recipe.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipes_ingredients_joint');
    }

    /**
     * The tags that belong to the recipe.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipes_tags_joint');
    }
}
