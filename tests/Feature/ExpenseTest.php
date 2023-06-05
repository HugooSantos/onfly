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
        $commomBody = $this->getCommonBodyDescription();
        $body = $this->changeBody($commomBody);
        $route = $this->getRouteWithId($token);

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
        $route = $this->getRouteWithId($token);

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

    public function test_list_all_user_expenses_sucess(): void
    {
        $token = $this->catchTokenAuth();
        $this->createExpense($token);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', '/api/expenses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [[
                    'id',
                    'user_id',
                    'description',
                    'amount',
                    'date'
                ]]
            ]);
    }

    public function test_list_specific_expense_sucess(): void
    {
        $token = $this->catchTokenAuth();
        $route = $this->getRouteWithId($token);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('get', $route);

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
}
