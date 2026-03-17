<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SymptomStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'severity' => ['required', 'in:mild,moderate,severe'],
            'description' => ['nullable', 'string'],
            'date_recorded' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
