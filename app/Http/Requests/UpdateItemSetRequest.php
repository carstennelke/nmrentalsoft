<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemSetRequest extends FormRequest
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
            'description' => ['nullable', 'string'],
            'unit' => ['required', 'string', 'max:10'],
        ];
    }
}
