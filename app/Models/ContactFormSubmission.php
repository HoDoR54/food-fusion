<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enums\ContactFormSubmissionType;

class ContactFormSubmission extends Model
{
    use HasUuids;

    protected $fillable = [
        'subject',
        'type',
        'message',
        'is_anonymous',
        'user_id',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'type' => ContactFormSubmissionType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
