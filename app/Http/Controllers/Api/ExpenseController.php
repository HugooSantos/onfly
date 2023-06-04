<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Services\ExpenseService;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{

    protected $expenseService;

    public function __construct()
    {
        $this->expenseService = new ExpenseService();
    }

    public function index(): JsonResponse
    {
        return $this->expenseService->index();
    }

    public function show(int $expenseId): JsonResponse
    {   
        return $this->expenseService->show($expenseId);
    }

    public function store(ExpenseRequest $expenseRequest): JsonResponse
    {  
        return $this->expenseService->store($expenseRequest);
    }

    public function update(ExpenseRequest $expenseRequest, int $expenseId): JsonResponse
    {
        return $this->expenseService->update($expenseRequest, $expenseId);
    }

    public function destroy(int $expenseId): JsonResponse
    {
        return $this->expenseService->destroy($expenseId);
    }
}
