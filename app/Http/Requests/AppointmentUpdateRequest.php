<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['sometimes', 'required', 'integer', 'exists:doctors,id'],
            'appointment_date' => ['sometimes', 'required', 'date', 'after:now'],
            'status' => ['sometimes', 'required', 'in:pending,confirmed,cancelled'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
