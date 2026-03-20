<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorSearchRequest;
use App\Models\Doctor;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    public function index(): JsonResponse
    {
        $doctors = Doctor::query()
            ->orderBy('name')
            ->get();

        return ApiResponse::success($doctors, 'Liste des medecins');
    }

    public function show(Doctor $doctor): JsonResponse
    {
        return ApiResponse::success($doctor, 'Detail du medecin');
    }

    public function search(DoctorSearchRequest $request): JsonResponse
    {
        $query = Doctor::query();

        if ($request->filled('specialty')) {
            $query->where('specialty', 'like', '%'.$request->string('specialty').'%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->string('city').'%');
        }

        $doctors = $query->orderBy('name')->get();

        return ApiResponse::success($doctors, 'Resultats de recherche');
    }
}
