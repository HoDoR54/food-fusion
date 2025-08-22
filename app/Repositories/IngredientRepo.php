<?php

namespace App\Repositories;

use App\Models\Ingredient;

class IngredientRepo extends AbstractRepo
{
    public function __construct(Ingredient $ingredient)
    {
        parent::__construct($ingredient);
    }

    public function findOrCreateByName(string $name, string $description = ''): Ingredient
    {
        return $this->model->firstOrCreate(
            ['name' => $name],
            ['description' => $description]
        );
    }
}
