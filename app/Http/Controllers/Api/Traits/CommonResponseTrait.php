<?php

namespace App\Http\Controllers\Api\Traits;

use App\Http\Resources\ExpenseResource;
use Illuminate\Http\JsonResponse;

trait CommonResponseTrait
{
    protected function sucessResponse(string $message, ExpenseResource $data, int $code): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function expenseNotFoundResponse(int $expenseId): JsonResponse
    {
        return response()->json([
            'message' => 'Despesa de ID: ' . $expenseId
                . ' não encontrada'
        ], 404);
    }

    protected function emptyExpenseResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Nenhuma despesa cadastrada ainda pra esse usuário'
        ], 404);
    }
}
