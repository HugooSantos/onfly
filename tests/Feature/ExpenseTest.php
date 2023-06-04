<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CommonExpenseTrait;
use Tests\Feature\Traits\CommonAuthTrait;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase,
        CommonAuthTrait,
        CommonExpenseTrait;

    public function test_create_expense_sucess(): void
    {
        $token = $this->catchTokenAuth();
        $body = $this->getCommonBodyDescription();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/expenses', $body);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'description',
                    'amount',
                    'date'
                ]
            ]);
    }

    public function test_update_expense_sucess(): void
    {
        $token = $this->catchTokenAuth();
        $expense = $this->createExpense();
        $commomBody = $this->getCommonBodyDescription($expense);
        $body = $this->changeBody($commomBody);
        $route = '/api/expenses/' . $expense['data']['id'];
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('put', $route, $body);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'description',
                    'amount',
                    'date'
                ]
            ]);
    }

    private function changeBody(array $commomBody): array
    {
        $commomBody['date'] = date('Y-m-d', strtotime('-' . mt_rand(0, 30) . ' days'));
        $commomBody['description'] = 'nova descrição';
        return $commomBody;
    }

    public function test_delete_expense_sucess(): void
    {
        $token = $this->catchTokenAuth();
        $body = $this->getCommonBodyDescription();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/expenses', $body)->getContent();
        $route = '/api/expenses/' . json_decode($response, true)['data']['id'];

        $responseDestroy = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('delete', $route);

        $responseDestroy->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'description',
                    'amount',
                    'date'
                ]
            ]);
    }
}
