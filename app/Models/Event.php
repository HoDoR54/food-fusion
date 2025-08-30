<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Enums\VenueType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'status',
        'type',
        'venue_type',
        'platform',
        'location',
        'organizer',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'status' => EventStatus::class,
            'type' => EventType::class,
            'venue_type' => VenueType::class,
        ];
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }


    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_attendees', 'event_id', 'user_id');
    }

    public function isUpcoming(): bool
    {
        return $this->start_time->isFuture() && $this->status === EventStatus::SCHEDULED;
    }

    public function isOngoing(): bool
    {
        return $this->status === EventStatus::ONGOING;
    }

    public function isCompleted(): bool
    {
        return $this->status === EventStatus::COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === EventStatus::CANCELLED;
    }

    public function canUserAttend(User $user): bool
    {
        return $this->isUpcoming() && !$this->attendees->contains($user);
    }

    public function canUserLeave(User $user): bool
    {
        return $this->isUpcoming() && $this->attendees->contains($user);
    }

    public function getAttendeesCountAttribute(): int
    {
        return $this->attendees()->count();
    }
}
