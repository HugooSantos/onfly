<?php

namespace App\Http\Controllers\Api\Traits;

use App\Http\Resources\ExpenseResource;
use Illuminate\Http\JsonResponse;

trait CommonResponseTrait
{
    protected function sucessResponse(string $message, ExpenseResource $data, int $code): JsonResponse
    {
        return response()->json([
            'massage' => $message,
            'data' => $data,
        ], $code);
    }

    protected function errorResponse(string $message, int $code): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    protected function expenseNotFound(int $expenseId): JsonResponse
    {
        return response()->json([
            'message' => 'Despesa de ID: ' . $expenseId
                . ' não encontrada'
        ], 404);
    }
}