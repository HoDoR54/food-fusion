<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasUuids;

    protected $fillable = [
        'action',
        'resource',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public static function findByActionAndResource(string $action, string $resource): ?Permission
    {
        return static::where('action', $action)
            ->where('resource', $resource)
            ->first();
    }

    public static function createOrGet(string $action, string $resource): Permission
    {
        return static::firstOrCreate([
            'action' => $action,
            'resource' => $resource,
        ]);
    }

    public function getFullNameAttribute(): string
    {
        return $this->action.':'.$this->resource;
    }
}
