<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'is_company' => ['required', 'boolean'],
            'title' => ['nullable', 'string', 'max:15'],
            'name' => ['required_unless:is_company,1', 'nullable', 'string', 'max:40'],
            'lastname' => ['required_unless:is_company,1', 'nullable', 'string', 'max:40'],
            'company_name' => ['required_if:is_company,1', 'nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'street' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:100'],
            'vat' => ['nullable', 'string', 'max:30'],
        ];
    }
}
