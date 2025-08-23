<?php

namespace App\Http\Requests;

use App\Enums\DifficultyLevel;
use App\Enums\RecipeStepType;
use App\Enums\TagType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'servings' => 'required|integer|min:1|max:20',
            'difficulty' => ['required', Rule::enum(DifficultyLevel::class)],
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120', // 5MB max
            
            'steps' => 'required|array|min:1',
            'steps.*.description' => 'required|string|max:1000',
            'steps.*.step_type' => ['required', Rule::enum(RecipeStepType::class)],
            'steps.*.estimated_time_taken' => 'required|integer|min:1|max:300', // max 5 hours
            'steps.*.order' => 'required|integer|min:1',
            
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.amount' => 'required|string|max:50',
            'ingredients.*.unit' => 'required|string|max:50',
            
            'tags' => 'nullable|array',
            'tags.*.name' => 'required_with:tags|string|max:255',
            'tags.*.type' => ['required_with:tags', Rule::enum(TagType::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Recipe name is required.',
            'description.required' => 'Recipe description is required.',
            'servings.required' => 'Number of servings is required.',
            'servings.min' => 'Servings must be at least 1.',
            'servings.max' => 'Servings cannot exceed 20.',
            'difficulty.required' => 'Difficulty level is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Image must be a PNG, JPG, or JPEG file.',
            'image.max' => 'Image size cannot exceed 5MB.',
            
            'steps.required' => 'At least one cooking step is required.',
            'steps.*.description.required' => 'Step description is required.',
            'steps.*.step_type.required' => 'Step type is required.',
            'steps.*.estimated_time_taken.required' => 'Estimated time is required.',
            'steps.*.estimated_time_taken.min' => 'Estimated time must be at least 1 minute.',
            'steps.*.estimated_time_taken.max' => 'Estimated time cannot exceed 5 hours.',
            
            'ingredients.required' => 'At least one ingredient is required.',
            'ingredients.*.name.required' => 'Ingredient name is required.',
            'ingredients.*.amount.required' => 'Ingredient amount is required.',
            'ingredients.*.unit.required' => 'Ingredient unit is required.',
            
            'tags.*.name.required_with' => 'Tag name is required when adding tags.',
            'tags.*.type.required_with' => 'Tag type is required when adding tags.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('steps')) {
            $steps = collect($this->steps)->map(function ($step, $index) {
                return [
                    'description' => $step['description'] ?? '',
                    'step_type' => $step['step_type'] ?? '',
                    'estimated_time_taken' => (int) ($step['estimated_time_taken'] ?? 0),
                    'order' => (int) ($step['order'] ?? $index + 1),
                ];
            })->toArray();
            
            $this->merge(['steps' => $steps]);
        }
    }
}
