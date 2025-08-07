<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo extends AbstractRepo
{
    public function __construct(Recipe $recipe) {
        parent::__construct($recipe);
    }
}
