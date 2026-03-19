<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SymptomStoreRequest;
use App\Http\Requests\SymptomUpdateRequest;
use App\Models\Symptom;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $symptoms = Symptom::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('date_recorded')
            ->get();

        return ApiResponse::success($symptoms, 'Liste des symptomes');
    }

    public function store(SymptomStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $symptom = Symptom::create($data);

        return ApiResponse::success($symptom, 'Symptome ajoute', 201);
    }

    public function show(Request $request, Symptom $symptom): JsonResponse
    {
        if ($symptom->user_id !== $request->user()->id) {
            return ApiResponse::error(['symptom' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        return ApiResponse::success($symptom, 'Detail du symptome');
    }

    public function update(SymptomUpdateRequest $request, Symptom $symptom): JsonResponse
    {
        if ($symptom->user_id !== $request->user()->id) {
            return ApiResponse::error(['symptom' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        $symptom->update($request->validated());

        return ApiResponse::success($symptom, 'Symptome mis a jour');
    }

    public function destroy(Request $request, Symptom $symptom): JsonResponse
    {
        if ($symptom->user_id !== $request->user()->id) {
            return ApiResponse::error(['symptom' => ['Acces refuse.']], 'Acces refuse', 403);
        }

        $symptom->delete();

        return ApiResponse::success(null, 'Symptome supprime');
    }
}
