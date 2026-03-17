<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Operation reussie', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data ?? (object) [],
            'message' => $message,
        ], $status);
    }

    public static function error(array|string|null $errors = null, string $message = 'Une erreur est survenue', int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors' => self::normalizeErrors($errors),
            'message' => $message,
        ], $status);
    }

    private static function normalizeErrors(array|string|null $errors): array
    {
        if (is_array($errors)) {
            return $errors;
        }

        if (is_string($errors) && $errors !== '') {
            return ['error' => [$errors]];
        }

        return [];
    }
}
