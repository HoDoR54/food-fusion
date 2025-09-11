<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'Page must be an integer.',
            'page.min' => 'Page must be at least 1.',
            'size.integer' => 'Size must be an integer.',
            'size.min' => 'Size must be at least 1.',
            'size.max' => 'Size may not be greater than 100.',
        ];
    }
}
