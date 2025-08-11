<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ip_address',
        'last_attempted_at',
        'attempts_count',
    ];

    protected $casts = [
        'last_attempted_at' => 'datetime',
        'attempts_count' => 'integer',
    ];

    public function getLoginAttemptsCount(): int
    {
        return $this->attempts_count;
    }

    public function getLastAttemptedAt(): ?\Carbon\Carbon
    {
        return $this->last_attempted_at;
    }

    public function getIpAddress(): string
    {
        return $this->ip_address;
    }

}
