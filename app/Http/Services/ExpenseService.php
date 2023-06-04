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

    private function sendNotification(Expense $expense): void
    {   
        $user = Auth::user();
        Notification::send($user, new ExpenseNotify($expense));
    }
}
