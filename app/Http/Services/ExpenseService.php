<?php

namespace App\Http\Services;

use App\Http\Controllers\Api\Traits\CommonResponseTrait;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ExpenseService
{
    use AuthorizesRequests, CommonResponseTrait;

    public function index(): JsonResponse
    {
        $userId = Auth::user()->id;
        $expenses = Expense::where('user_id', $userId)->get();

        return $this->sucessResponse(
            'Todas as despesas desse usuário',
            new ExpenseResource($expenses),
            200
        );
    }

    public function show(int $expenseId): JsonResponse
    {
        $expense = Expense::find($expenseId);

        if (is_null($expense)) {
            return $this->expenseNotFound($expenseId);
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
        Expense::create($expenseRequest->toArray());

        return $this->sucessResponse(
            'Despesa criada com sucesso',
            new ExpenseResource($expenseRequest),
            201
        );
    }

    public function update(ExpenseRequest $expenseRequest, int $expenseId): JsonResponse
    {
        $expense = Expense::find($expenseId);

        if (is_null($expense)) {
            return $this->expenseNotFound($expenseId);
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
            return $this->expenseNotFound($expenseId);
        }

        $this->authorize('delete', $expense);
        $expense->delete();

        return $this->sucessResponse(
            'Remoção da despesa feita com sucesso.',
            new ExpenseResource($expense),
            200
        );
    }
}