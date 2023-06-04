<?php

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Http\JsonResponse;

trait AuthenticationResponseTrait
{
    private function getAuthenticatedResponse(string $token): JsonResponse
    {
        return response()->json([
            'status' => 'Autenticado',
            'auth' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    private function getFailedAuthenticatedResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Falha ao Autenticar',
        ], 401);
    }
}