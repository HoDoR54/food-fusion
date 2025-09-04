<?php

namespace App\View\Components;

use App\Services\RecipeService;
use App\Enums\DifficultyLevel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeFilters extends Component
{
    private readonly RecipeService $_recipeService;

    // Public properties for Blade
    public array $difficultyLevels;
    public array $dietaryPreferences;
    public array $cuisineTypes;
    public array $courses;
    public array $cookingMethods;
    public array $occasions;

    public function __construct(RecipeService $recipeService)
    {
        $this->_recipeService = $recipeService;

        $this->difficultyLevels = $this->getDifficultyLevels();
        $this->dietaryPreferences = $this->getDietaryPreferences();
        $this->cuisineTypes = $this->getCuisineTypes();
        $this->courses = $this->getCourses();
        $this->cookingMethods = $this->getCookingMethods();
        $this->occasions = $this->getOccasions();
    }

    private function getDifficultyLevels(): array
    {
        $levels = [];
        foreach (DifficultyLevel::cases() as $level) {
            $levels[$level->value] = $level->label();
        }
        return $levels;
    }

    private function getDietaryPreferences(): array
    {
        $preferences = $this->_recipeService->getDietaryPreferences();
        $result = [];
        foreach ($preferences as $preference) {
            if (!empty($preference)) {
                $result[$preference] = ucfirst($preference);
            }
        }
        return $result;
    }
    
    private function getCuisineTypes(): array
    {
        $cuisines = $this->_recipeService->getCuisineTypes();
        $result = [];
        foreach ($cuisines as $cuisine) {
            $result[$cuisine] = ucfirst($cuisine);
        }
        return $result;
    }

    private function getCourses(): array
    {
        $courses = $this->_recipeService->getCourses();
        $result = [];
        foreach ($courses as $course) {
            $result[$course] = ucfirst($course);
        }
        return $result;
    }

    private function getCookingMethods(): array
    {
        $methods = $this->_recipeService->getCookingMethods();
        $result = [];
        foreach ($methods as $method) {
            $result[$method] = ucfirst($method);
        }
        return $result;
    }

    private function getOccasions(): array
    {
        $occasions = $this->_recipeService->getOccasions();
        $result = [];
        foreach ($occasions as $occasion) {
            $result[$occasion] = ucfirst($occasion);
        }
        return $result;
    }

    public function render(): View|Closure|string
    {
        return view('recipes.recipe-filters');
    }
}