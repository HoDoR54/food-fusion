<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search_term' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string'],
            'topic' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'search_term.string' => 'Search term must be a string.',
            'search_term.max' => 'Search term cannot exceed 255 characters.',
            'category.string' => 'Category must be a string.',
            'topic.string' => 'Topic must be a string.',
        ];
    }
}
