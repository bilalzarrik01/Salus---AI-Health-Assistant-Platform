<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Models\Appointment;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $appointments = Appointment::query()
            ->with('doctor')
            ->where('user_id', $request->user()->id)
            ->orderBy('appointment_date')
            ->get();

        return ApiResponse::success($appointments, 'Liste des rendez-vous');
    }

    public function store(AppointmentStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $appointment = Appointment::create($data);

        return ApiResponse::success($appointment, 'Rendez-vous cree', 201);
    }

    public function show(Request $request, Appointment $appointment): JsonResponse
    {
        if ($appointment->user_id !== $request->user()->id) {
            return ApiResponse::error(['appointment' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        $appointment->load('doctor');

        return ApiResponse::success($appointment, 'Detail du rendez-vous');
    }

    public function update(AppointmentUpdateRequest $request, Appointment $appointment): JsonResponse
    {
        if ($appointment->user_id !== $request->user()->id) {
            return ApiResponse::error(['appointment' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        $appointment->update($request->validated());

        return ApiResponse::success($appointment->fresh('doctor'), 'Rendez-vous mis a jour');
    }

    public function destroy(Request $request, Appointment $appointment): JsonResponse
    {
        if ($appointment->user_id !== $request->user()->id) {
            return ApiResponse::error(['appointment' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        $appointment->delete();

        return ApiResponse::success(null, 'Rendez-vous annule');
    }
}
