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
        'username',
        'email',
        'phone',
        'mastery_level',
        'password',
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

    public function getId () {
        return $this->getKey();
    }

    public function refresh_tokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'posted_by');
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
