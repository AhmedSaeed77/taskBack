<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $request = 'title';
        return [
            'username' => 'required:users',
            'email' => 'required:users',
            'bio' => 'required:users',
            'file' => [
                Rule::requiredIf(function () use ($request) {
                    return 'title' !== null;
                }),
                'file',
                'mimes:jpeg,jpg,png,pdf',
            ],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => "username is required",
            'email.required' => "email is required",
            'bio.required' => "bio is required",
            'file.required_if' => "file is required"
        ];
    }
}
