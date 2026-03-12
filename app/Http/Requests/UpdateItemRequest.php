<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'short_name' => ['required', 'string', 'max:12'],
            'long_name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'has_dry_hire_option' => ['boolean'],
            'unit' => ['required', 'string', 'max:10'],
        ];
    }
}
