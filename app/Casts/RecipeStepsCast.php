<?php

namespace App\Casts;

use App\DTO\Requests\RecipeStep;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class RecipeStepsCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);
        
        if (!is_array($decoded)) {
            return null;
        }

        return array_map(
            fn(array $step) => RecipeStep::fromArray($step),
            $decoded
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException('Steps must be an array');
        }

        $steps = array_map(function ($step) {
            if ($step instanceof RecipeStep) {
                return $step->toArray();
            }
            
            if (is_array($step)) {
                // Validate required fields
                $required = ['order', 'description', 'estimated_time_taken'];
                foreach ($required as $field) {
                    if (!isset($step[$field])) {
                        throw new InvalidArgumentException("Missing required field: {$field}");
                    }
                }
                return $step;
            }
            
            throw new InvalidArgumentException('Each step must be a RecipeStep instance or array');
        }, $value);

        return json_encode($steps);
    }
}
