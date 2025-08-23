<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\MasteryLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 
                'string', 
                'min:3',
                'max:255', 
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phoneNumber' => ['required', 'string'],
            'password' => ['required', 'string', 'min:12'],
            'mastery_level' => ['required', 'in:' . implode(',', MasteryLevel::values())],
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => 'The first name field is required.',
            'lastName.required' => 'The last name field is required.',
            'username.required' => 'The username field is required.',
            'username.min' => 'Username must be at least 3 characters long.',
            'username.unique' => 'Username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'Email is already registered.',
            'phoneNumber.required' => 'The phone number field is required.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 12 characters long.',
            'mastery_level.required' => 'Please select your cooking level.',
            'mastery_level.in' => 'Please select a valid cooking level.',
        ];
    }
}
