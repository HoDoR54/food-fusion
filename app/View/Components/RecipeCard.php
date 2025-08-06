<?php

namespace App\View\Components;

use App\Models\Recipe;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeCard extends Component
{
    public Recipe $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function render()
    {
        return view('components.recipe-card');
    }
}
