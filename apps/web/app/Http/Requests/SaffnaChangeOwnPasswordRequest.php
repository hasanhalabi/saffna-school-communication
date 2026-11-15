<?php

namespace App\Http\Requests;

use App\Http\Responses\SaffnaJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class SaffnaChangeOwnPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => [
                'required',
                'string',
                'min:12',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'different:current_password',
                'confirmed',
            ],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.required' => __('saffna.validation.current_password_required'),
            'current_password.current_password' => __('saffna.validation.current_password_invalid'),
            'password.required' => __('saffna.validation.new_password_required'),
            'password.min' => __('saffna.validation.new_password_policy'),
            'password.regex' => __('saffna.validation.new_password_policy'),
            'password.different' => __('saffna.validation.new_password_different'),
            'password.confirmed' => __('saffna.validation.new_password_confirmation'),
            'password_confirmation.required' => __('saffna.validation.password_confirmation_required'),
        ];
    }

    public function newPassword(): string
    {
        return (string) $this->validated('password');
    }

    protected function prepareForValidation(): void
    {
        SaffnaJsonResponse::applyLocale($this);
    }
}
