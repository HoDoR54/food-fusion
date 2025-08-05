<?php

namespace App\Services;

use App\Repositories\RecipeRepo;

class RecipeService
{
    protected RecipeRepo $_recipeRepo;

    public function __construct(RecipeRepo $recipeRepo) {
        $this->_recipeRepo = $recipeRepo;
    }

    public function getRecipes() {
        return $this->_recipeRepo->all();
    }
}
