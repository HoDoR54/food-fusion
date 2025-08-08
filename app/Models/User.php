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
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'mastery_level',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mastery_level' => MasteryLevel::class,
        ];
    }

    public function refresh_tokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'posted_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(RecipeVote::class);
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->upvotes();
    }

    public function downvotes(): HasMany
    {
        return $this->hasMany(RecipeVote::class)->downvotes();
    }

    public function hasVotedOn(Recipe $recipe): bool
    {
        return $this->votes()->where('recipe_id', $recipe->id)->exists();
    }

    public function getVoteOn(Recipe $recipe): ?RecipeVote
    {
        return $this->votes()->where('recipe_id', $recipe->id)->first();
    }
}
