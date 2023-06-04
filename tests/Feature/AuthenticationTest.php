<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_catch_token_function_sucess(): void
    {
        $user = $this->createUser();
        $body = $this->getBodyToCatchToken($user);
        $response = $this->postJson('/api/auth/login/', $body);

        $response->assertJsonStructure([
            'status',
            'auth' => [
                'token',
                'type'
            ]
        ]);
    }

    public function test_invalid_user_function_error(): void
    {
        $user = $this->createUser();
        $body = $this->getBodyToCatchToken($user);
        $body['password'] = (string) mt_rand(10000000, 99999999);
        $response = $this->postJson('/api/auth/login/', $body);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Falha ao Autenticar, usuário não encontrado.'
            ]);
    }

    private function getBodyToCatchToken(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => 'password'
        ];
    }

    private function createUser(): User
    {
        return User::factory()->create([
            'email' => 'testeDaPegaDoToken@gmail.com',
            'name' => 'teste',
            'password' => bcrypt('password')
        ]);
    }
}
