<?php

namespace App\Policies;

use App\Http\Controllers\Api\Traits\CommonResponseTrait;
use Illuminate\Auth\Access\Response;
use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    use CommonResponseTrait;

    public function create(User $user): bool
    {
        return true;
    }

    public function show(User $userModel, Expense $expenseModel): Response
    {
        return $this->checkUserCanOperate($userModel->id, $expenseModel->user_id);
    }

    public function update(User $userModel, Expense $expenseModel): Response
    {
        return $this->checkUserCanOperate($userModel->id, $expenseModel->user_id);
    }

    public function delete(User $userModel, Expense $expenseModel): Response
    {
        return $this->checkUserCanOperate($userModel->id, $expenseModel->user_id);
    }

    private function checkUserCanOperate(int $userId, int $expenseUserId): Response
    {
        return $userId == $expenseUserId
            ? Response::allow()
            : Response::deny('Usuário não autorizado a operar essa despesa.', 403);
    }
}
