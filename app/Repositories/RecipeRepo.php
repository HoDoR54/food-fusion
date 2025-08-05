<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepo extends AbstractRepo
{
    public function __construct(Recipe $recipe) {
        parent::__construct($recipe);
    }
}
