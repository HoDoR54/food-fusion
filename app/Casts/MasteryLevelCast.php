<?php

namespace App\Casts;

use App\Enums\MasteryLevel;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MasteryLevelCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?MasteryLevel
    {
        return $value ? MasteryLevel::from($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value instanceof MasteryLevel ? $value->value : $value;
    }
}
