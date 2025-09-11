<?php

namespace App\Casts;

use App\DTO\Requests\RecipeStep;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class RecipeStepsCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Collection
    {
        if ($value === null) {
            return collect();
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded)) {
            return collect();
        }

        return collect($decoded)->map(
            fn (array $step) => RecipeStep::fromArray($step)
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if (! is_iterable($value)) {
            throw new InvalidArgumentException('Steps must be iterable');
        }

        $steps = collect($value)->map(function ($step) {
            if ($step instanceof RecipeStep) {
                return $step->toArray();
            }

            if (is_array($step)) {
                $required = ['order', 'description', 'step_type', 'estimated_time_taken'];
                foreach ($required as $field) {
                    if (! isset($step[$field])) {
                        throw new InvalidArgumentException("Missing required field: {$field}");
                    }
                }

                return RecipeStep::fromArray($step)->toArray();
            }

            throw new InvalidArgumentException('Each step must be a RecipeStep instance or array');
        });

        return json_encode($steps->toArray());
    }
}
