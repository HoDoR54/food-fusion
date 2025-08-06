<?php

namespace App\Services;

use App\Repositories\RecipeRepo;
use App\DTO\Requests\PaginationQuery;
use App\DTO\Responses\PaginatedResponse;

class RecipeService
{
    protected RecipeRepo $_recipeRepo;

    public function __construct(RecipeRepo $recipeRepo) {
        $this->_recipeRepo = $recipeRepo;
    }

    public function getRecipes(PaginationQuery $paginationQuery): PaginatedResponse {
        $items = $this->_recipeRepo->paginate($paginationQuery->getPage(), ['*'], $paginationQuery->getSize());
        $total = $this->_recipeRepo->count();

        return new PaginatedResponse(
            $items,
            $total,
            $paginationQuery->getPage(),
            $paginationQuery->getSize()
        );
    }

    public function getRecipeById($id) {
        return $this->_recipeRepo->find($id);
    }
}
