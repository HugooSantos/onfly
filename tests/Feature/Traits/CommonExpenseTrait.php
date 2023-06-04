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

    protected function createExpense(): array
    {
        $token = $this->catchTokenAuth();
        $body = $this->getCommonBodyDescription();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/expenses', $body)
            ->getContent();
        return json_decode($response, true);
    }
}
