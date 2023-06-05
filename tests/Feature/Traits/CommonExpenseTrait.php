<?php

namespace Tests\Feature\Traits;

trait CommonExpenseTrait
{
    use CommonAuthTrait;

    protected function getCommonBodyDescription(): array
    {
        return [
            "description" => "teste",
            "amount" => mt_rand(0, 30),
            "date" => date('Y-m-d', strtotime('-' . mt_rand(0, 30) . ' days'))
        ];
    }

    protected function createExpense(string $token): string
    {
        $body = $this->getCommonBodyDescription();
        return $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/expenses', $body)->getContent();
    }

    protected function getLastCreatedExpenseId(string $token): int
    {
        $bodyResponse = $this->createExpense($token);
        return json_decode($bodyResponse, true)['data']['id'];
    }

    protected function getRouteWithId(string $token): string
    {
        $expenseId = $this->getLastCreatedExpenseId($token);
        return '/api/expenses/' . $expenseId;
    }
}
