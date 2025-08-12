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
    private string|null $dietaryPreference;
    private string|null $cuisineType;
    private string|null $course;
    private string|null $cookingMethod;
    private string|null $occasion;


    public function __construct(Request $request) {
        $this->searchTerm = $request->input('search_term', '');
        $this->author = $request->input('author', '');
        $this->ingredient = $request->input('ingredient', '');
        $this->difficultyLevel = $request->input('difficulty_level', null);
        $this->dietaryPreference = $request->input('dietary_preference', null);
        $this->cuisineType = $request->input('cuisine_type', null);
        $this->course = $request->input('course', null);
        $this->cookingMethod = $request->input('cooking_method', null);
        $this->occasion = $request->input('occasion', null);
    }

    public function hasFilters(): bool
    {
        return !empty($this->searchTerm) ||
            !empty($this->author) ||
            !empty($this->ingredient) ||
            !empty($this->difficultyLevel) ||
            !empty($this->dietaryPreference) ||
            !empty($this->cuisineType) ||
            !empty($this->course) ||
            !empty($this->cookingMethod) ||
            !empty($this->occasion);
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

    public function getDietaryPreference(): ?string {
        return $this->dietaryPreference;
    }

    public function getCuisineType(): ?string {
        return $this->cuisineType;
    }

    public function getCourse(): ?string {
        return $this->course;
    }

    public function getCookingMethod(): ?string {
        return $this->cookingMethod;
    }

    public function getOccasion(): ?string {
        return $this->occasion;
    }
}