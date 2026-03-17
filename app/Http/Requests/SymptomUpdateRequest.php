<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SymptomUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'severity' => ['sometimes', 'required', 'in:mild,moderate,severe'],
            'description' => ['sometimes', 'nullable', 'string'],
            'date_recorded' => ['sometimes', 'required', 'date'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
