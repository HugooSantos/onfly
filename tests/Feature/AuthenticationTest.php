<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CommonAuthTrait;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, CommonAuthTrait;

    public function test_catch_token_sucess(): void
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

    public function test_invalid_user_error(): void
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
}
