<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'failed_login_attempts';

    protected $fillable = [
        'ip_address',
        'last_attempted_at',
        'attempts_count',
    ];

    protected $casts = [
        'last_attempted_at' => 'datetime',
        'attempts_count' => 'integer',
    ];

    public function getAttemptsCount(): int
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
