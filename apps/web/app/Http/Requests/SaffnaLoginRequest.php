<?php

namespace App\Http\Requests;

use App\Http\Responses\SaffnaJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class SaffnaLoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => __('saffna.validation.email_required'),
            'email.email' => __('saffna.validation.email_invalid'),
            'password.required' => __('saffna.validation.password_required'),
            'remember.boolean' => __('saffna.validation.remember_invalid'),
        ];
    }

    /**
     * @return array{email: string, password: string, status: string}
     */
    public function credentials(): array
    {
        return [
            'email' => strtolower(trim((string) $this->validated('email'))),
            'password' => (string) $this->validated('password'),
            'status' => 'active',
        ];
    }

    protected function prepareForValidation(): void
    {
        SaffnaJsonResponse::applyLocale($this);

        $this->merge([
            'email' => strtolower(trim((string) $this->input('email'))),
        ]);
    }
}
