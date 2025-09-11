<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\MasteryLevel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'mastery_level',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    protected $appends = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mastery_level' => MasteryLevel::class,
        ];
    }

    public function getId()
    {
        return $this->getKey();
    }

    public function refresh_tokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function savedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'saved_recipes')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function contactFormSubmissions(): HasMany
    {
        return $this->hasMany(ContactFormSubmission::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'Admin';
    }

    public function recipeAttempts(): HasMany
    {
        return $this->hasMany(RecipeAttempt::class);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function hasPermission(string $action, string $resource): bool
    {
        return $this->role?->hasPermission($action, $resource) ?? false;
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'posted_by');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer');
    }

    public function attendingEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_attendees', 'user_id', 'event_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function voteOnBlog(Blog $blog, string $direction): Vote
    {
        // Remove existing vote if any
        $this->votes()->where('blog_id', $blog->id)->delete();

        // Create new vote
        return $this->votes()->create([
            'blog_id' => $blog->id,
            'direction' => $direction,
        ]);
    }

    public function removeVoteFromBlog(Blog $blog): bool
    {
        return $this->votes()->where('blog_id', $blog->id)->delete() > 0;
    }

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
