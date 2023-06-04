<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_sucess(): void
    {
        $body = $this->getBodyToCreateUser();
        $response = $this->postJson('/api/users', $body);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'Sucesso',
                'message' => 'Criação do usuário feita com sucesso'
            ]);
    }

    public function test_create_user_error(): void
    {
        $body = $this->getBodyToCreateUser();
        $this->postJson('/api/users', $body);
        $response = $this->postJson('/api/users', $body);
        $response->assertJson([
            'message' => 'O e-mail informado já está em uso',
            'errors' => [
                'email' => ['O e-mail informado já está em uso']
            ]
        ]);
    }

    private function getBodyToCreateUser(): array
    {
        return [
            'name' => 'Usuário do teste criação',
            'email' => 'testeDaCriacaoUsuario@gmail.com',
            'password' => 'password'
        ];
    }
}
