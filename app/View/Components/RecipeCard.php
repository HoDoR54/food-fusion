<?php

namespace App\View\Components;

use App\Models\Recipe;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeCard extends Component
{
    public Recipe $recipe;

    public function __construct(Recipe|array $recipe)
    {
        if (is_array($recipe)) {
            if (isset($recipe['recipe'])) {
                $recipeData = $recipe['recipe'];
                if ($recipeData instanceof Recipe) {
                    $this->recipe = $recipeData;
                } elseif (is_array($recipeData)) {
                    $this->recipe = new Recipe($recipeData);
                    $this->setNonFillableAttributes($this->recipe, $recipeData);
                } else {
                    throw new \InvalidArgumentException('Invalid recipe data structure');
                }
            } elseif (isset($recipe['id'])) {
                $this->recipe = new Recipe($recipe);
                $this->setNonFillableAttributes($this->recipe, $recipe);
            } else {
                throw new \InvalidArgumentException('Recipe array must contain recipe data or have recipe key');
            }
        } elseif ($recipe instanceof Recipe) {
            $this->recipe = $recipe;
        } else {
            throw new \InvalidArgumentException('Recipe component expects a Recipe model or array with recipe data');
        }
    }

    public function getDifficultyColor(): string
    {
        return match ($this->recipe->difficulty) {
            'Easy' => 'green-500',
            'Medium' => 'yellow-500',
            'Hard' => 'red-500',
            default => 'gray-500',
        };
    }


    private function setNonFillableAttributes(Recipe $recipe, array $data): void
    {
        foreach (['id', 'created_at', 'updated_at'] as $attr) {
            if (isset($data[$attr])) {
                $recipe->$attr = $data[$attr];
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.recipe-card');
    }
}
