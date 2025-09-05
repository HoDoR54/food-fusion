<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:5',
            'content' => 'required|string|min:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tags' => 'nullable|array',
            'tags.*.name' => 'required_with:tags|string|max:50',
            'tags.*.type' => 'required_with:tags|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Blog title is required.',
            'title.min' => 'Blog title must be at least 5 characters long.',
            'title.max' => 'Blog title cannot exceed 255 characters.',
            'content.required' => 'Blog content is required.',
            'content.min' => 'Blog content must be at least 50 characters long.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Image must be a jpeg, png, jpg, or gif file.',
            'image.max' => 'Image size cannot exceed 5MB.',
            'tags.*.name.required_with' => 'Tag name is required when tags are provided.',
            'tags.*.type.required_with' => 'Tag type is required when tags are provided.',
        ];
    }
}
