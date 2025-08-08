<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\MasteryLevel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'mastery_level',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mastery_level' => MasteryLevel::class,
        ];
    }

    /**
     * Get the recipes posted by this user.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'posted_by');
    }

    /**
     * Get the votes cast by this user.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(RecipeVote::class);
    }

    /**
     * Get the upvotes cast by this user.
     */
    public function upvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->upvotes();
    }

    /**
     * Get the downvotes cast by this user.
     */
    public function downvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->downvotes();
    }

    /**
     * Check if user has voted on a recipe.
     */
    public function hasVotedOn(Recipe $recipe): bool
    {
        return $this->votes()->where('recipe_id', $recipe->id)->exists();
    }

    /**
     * Get user's vote on a specific recipe.
     */
    public function getVoteOn(Recipe $recipe): ?RecipeVote
    {
        return $this->votes()->where('recipe_id', $recipe->id)->first();
    }
}
