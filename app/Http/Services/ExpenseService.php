<?php

namespace App\Http\Services;

use App\Http\Controllers\Api\Traits\CommonResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\ExpenseRequest;
use App\Notifications\ExpenseNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Expense;

class ExpenseService
{
    use AuthorizesRequests, CommonResponseTrait;

    public function show(int $expenseId): JsonResponse
    {
        $expense = Expense::find($expenseId);

        if (is_null($expense)) {
            return $this->expenseNotFoundResponse($expenseId);
        }

        $this->authorize('show', $expense);

        return $this->sucessResponse(
            'Despesa listada com sucesso.',
            new ExpenseResource($expense),
            200
        );
    }

    public function store(ExpenseRequest $expenseRequest): JsonResponse
    {
        $expense = Expense::create($expenseRequest->toArray())
            ->get()
            ->last();

        $this->sendNotification($expense);

        return $this->sucessResponse(
            'Despesa criada com sucesso',
            new ExpenseResource($expense),
            201
        );
    }

    private function sendNotification(Expense $expense): void
    {
        $user = Auth::user();
        Notification::send($user, new ExpenseNotify($expense));
    }

    public function update(ExpenseRequest $expenseRequest, int $expenseId): JsonResponse
    {
        $expense = Expense::find($expenseId);

        if (is_null($expense)) {
            return $this->expenseNotFoundResponse($expenseId);
        }

        $this->authorize('update', $expense);

        $expense->update($expenseRequest->toArray());

        return $this->sucessResponse(
            'Despesa atualizada com sucesso',
            new ExpenseResource($expense),
            200
        );
    }

    public function destroy(int $expenseId): JsonResponse
    {
        $expense = Expense::find($expenseId);

        if (is_null($expense)) {
            return $this->expenseNotFoundResponse($expenseId);
        }

        $this->authorize('delete', $expense);

        $expense->delete();

        return $this->sucessResponse(
            'Remoção da despesa feita com sucesso.',
            new ExpenseResource($expense),
            200
        );
    }

    public function index(): JsonResponse
    {
        $userId = Auth::user()->id;
        $expenses = Expense::where('user_id', $userId)->get();

        if (is_null($expenses->first())) {
            return $this->emptyExpenseResponse();
        };

        return response()->json([
            'message' => 'Todas as despesas desse usuário',
            'data' => $expenses->toArray(),
        ], 200);
    }
}
