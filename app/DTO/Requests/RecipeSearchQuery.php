<?php

namespace App\DTO\Requests;

use App\Enums\DifficultyLevel;
use Illuminate\Http\Request;

class RecipeSearchQuery
{
    private string|null $searchTerm;
    private string|null $author;
    private string|null $ingredient;
    private string|null $difficultyLevel;


    public function __construct(Request $request) {
        $this->searchTerm = $request->input('search_term', '');
        $this->author = $request->input('author', '');
        $this->ingredient = $request->input('ingredient', '');
        $this->difficultyLevel = $request->input('difficulty_level', null);
    }

    public function hasFilters(): bool
    {
        return !empty($this->searchTerm) ||
            !empty($this->author) ||
            !empty($this->ingredient) ||
            !empty($this->minDurationMinutes) ||
            !empty($this->maxDurationMinutes) ||
            !empty($this->difficultyLevel);
    }

    public function getSearchTerm(): string {
        return $this->searchTerm;
    }

    public function getSearchAuthor(): ?string {
        return $this->author;
    }

    public function getSearchIngredient(): ?string {
        return $this->ingredient;
    }
    
    public function getSearchDifficultyLevel(): ?DifficultyLevel {
        if (empty($this->difficultyLevel)) {
            return null;
        }
        
        try {
            return DifficultyLevel::fromValue($this->difficultyLevel);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }
}