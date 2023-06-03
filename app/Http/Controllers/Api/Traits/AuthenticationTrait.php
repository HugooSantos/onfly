<?php

namespace App\Http\Controllers\Api\Traits;

trait AuthenticationTrait
{
    private function getAuthenticatedResponse(string $token): object
    {
        return response()->json([
            'status' => 'Autenticado',
            'auth' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    private function getFailedAuthenticatedResponse(): object
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Falha ao Autenticar',
        ], 401);
    }
}
