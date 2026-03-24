<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'specialty' => ['nullable', 'string', 'max:255', 'required_without:city'],
            'city' => ['nullable', 'string', 'max:255', 'required_without:specialty'],
        ];
    }
}
