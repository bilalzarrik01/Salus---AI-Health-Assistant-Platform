<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AiAdviceRequest;
use App\Models\AiAdvice;
use App\Services\AiHealthAdviceService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiAdviceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $advices = AiAdvice::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('generated_at')
            ->get();

        return ApiResponse::success($advices, 'Historique des conseils');
    }

    public function generate(AiAdviceRequest $request, AiHealthAdviceService $service): JsonResponse
    {
        $user = $request->user();
        $days = $request->integer('days', 7);
        $limit = $request->integer('limit', 10);

        $since = now()->subDays($days)->toDateString();
        $symptoms = $user->symptoms()
            ->whereDate('date_recorded', '>=', $since)
            ->orderByDesc('date_recorded')
            ->limit($limit)
            ->get();

        if ($symptoms->isEmpty()) {
            return ApiResponse::error(['symptoms' => ['Aucun symptome recent.']], 'Aucun symptome', 422);
        }

        try {
            $adviceText = $service->generateAdvice($symptoms);
        } catch (\Throwable $exception) {
            return ApiResponse::error(['ai' => [$exception->getMessage()]], 'Echec IA', 502);
        }

        $snapshot = $symptoms->map(function ($symptom) {
            return [
                'id' => $symptom->id,
                'name' => $symptom->name,
                'severity' => $symptom->severity,
                'description' => $symptom->description,
                'date_recorded' => $symptom->date_recorded?->toDateString(),
            ];
        })->values();

        $aiAdvice = AiAdvice::create([
            'user_id' => $user->id,
            'advice' => $adviceText,
            'symptoms_snapshot' => $snapshot,
            'generated_at' => now(),
        ]);

        return ApiResponse::success([
            'advice' => $aiAdvice->advice,
            'generated_at' => $aiAdvice->generated_at,
        ], 'Conseils generes', 201);
    }
}
