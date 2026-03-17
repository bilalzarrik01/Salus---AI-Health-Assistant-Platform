<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AiAdviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'days' => ['sometimes', 'integer', 'min:1', 'max:30'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ];
    }
}
