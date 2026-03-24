<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiHealthAdviceService
{
    public function generateAdvice(Collection $symptoms): string
    {
        $apiKey = config('services.openai.key');
        if (! $apiKey) {
            throw new RuntimeException('OPENAI_API_KEY manquant.');
        }

        $baseUrl = rtrim(config('services.openai.base_url', 'https://api.openai.com'), '/');
        $model = config('services.openai.model', 'gpt-4o-mini');
        $timeout = (int) config('services.openai.timeout', 20);

        $prompt = $this->buildPrompt($symptoms);

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout($timeout)
            ->post($baseUrl.'/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful health assistant. Provide general wellness advice, not medical diagnosis.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.7,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Echec de la requete IA.');
        }

        $advice = data_get($response->json(), 'choices.0.message.content');

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
