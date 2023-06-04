<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function show(User $userModel, Expense $expenseModel): Response
    {
        return $userModel->id == $expenseModel->user_id
            ? Response::allow()
            : Response::deny('Usuário não autorizado a operar essa despesa.');
    }

    public function update(User $userModel, Expense $expenseModel): Response
    {
        return $userModel->id == $expenseModel->user_id
            ? Response::allow()
            : Response::deny('Usuário não autorizado a operar essa despesa.');
    }

    public function delete(User $userModel, Expense $expenseModel): Response
    {
        return $userModel->id == $expenseModel->user_id
            ? Response::allow()
            : Response::deny('Usuário não autorizado a operar essa despesa.');
    }
}
