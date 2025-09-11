<?php

namespace App\Http\Requests;

use App\Enums\ContactFormSubmissionType;
use Illuminate\Foundation\Http\FormRequest;

class ContactSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:'.implode(',', array_column(ContactFormSubmissionType::cases(), 'value')),
            'is_anonymous' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Please provide a subject.',
            'message.required' => 'Please provide a message.',
            'type.required' => 'Please select a contact form type.',
            'is_anonymous.boolean' => 'Invalid value for anonymous submission.',
        ];
    }
}
