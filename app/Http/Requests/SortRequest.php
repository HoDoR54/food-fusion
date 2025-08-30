<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sort_by' => 'nullable|string|in:name,created_at,updated_at,difficulty,servings,popularity,start_time,end_time',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'sort_by.string' => 'Sort by must be a string.',
            'sort_by.in' => 'Sort by must be one of the following: name, created_at, updated_at, difficulty, servings, popularity.',
            'sort_direction.string' => 'Sort direction must be a string.',
            'sort_direction.in' => 'Sort direction must be either asc or desc.',
        ];
    }
}
