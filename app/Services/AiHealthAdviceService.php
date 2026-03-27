<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiHealthAdviceService
{
    public function generateAdvice(Collection $symptoms): string
    {
        $apiKey = config('services.gemini.key');
        if (! $apiKey) {
            throw new RuntimeException('GEMINI_API_KEY manquant.');
        }

        $baseUrl = rtrim(config('services.gemini.base_url', 'https://generativelanguage.googleapis.com'), '/');
        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $timeout = (int) config('services.gemini.timeout', 20);

        $systemPrompt = 'You are a helpful health assistant. Provide general wellness advice, not medical diagnosis.';
        $prompt = $this->buildPrompt($symptoms);

        $response = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->acceptJson()
            ->timeout($timeout)
            ->post($baseUrl.'/v1beta/models/'.$model.':generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $systemPrompt."\n\n".$prompt,
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Echec de la requete IA.');
        }

        $advice = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! is_string($advice) || trim($advice) === '') {
            throw new RuntimeException('Reponse IA invalide.');
        }

        return trim($advice);
    }

    private function buildPrompt(Collection $symptoms): string
    {
        $lines = $symptoms
            ->map(function ($symptom) {
                $label = $symptom->name ?? 'symptom';
                $severity = $symptom->severity ? ' ('.$symptom->severity.')' : '';

                return $label.$severity;
            })
            ->filter()
            ->values();

        $body = $lines->implode("\n");

        return "User symptoms:\n".$body."\nProvide general wellness advice, not medical diagnosis.";
    }
}
