<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DifficultyLevel;
use Illuminate\Validation\Rule;

class RecipeSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search_term'        => ['nullable', 'string'],
            'author'             => ['nullable', 'string'],
            'ingredient'         => ['nullable', 'string'],
            'difficulty_level'   => ['nullable', Rule::enum(DifficultyLevel::class)],
            'dietary_preference' => ['nullable', 'string'],
            'cuisine_type'       => ['nullable', 'string'],
            'course'             => ['nullable', 'string'],
            'cooking_method'     => ['nullable', 'string'],
            'occasion'           => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'search_term.string' => 'Search term must be a string.',
            'author.string'      => 'Author must be a string.',
            'ingredient.string'  => 'Ingredient must be a string.',
            'difficulty_level.enum' => 'Invalid difficulty level.',
            'dietary_preference.string' => 'Dietary preference must be a string.',
            'cuisine_type.string' => 'Cuisine type must be a string.',
            'course.string'      => 'Course must be a string.',
            'cooking_method.string' => 'Cooking method must be a string.',
            'occasion.string'    => 'Occasion must be a string.',
        ];
    }
}
