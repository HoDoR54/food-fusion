<?php

namespace App\Models;

use App\Enums\ContactFormSubmissionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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
