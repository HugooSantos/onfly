<?php

namespace Tests\Feature\Traits;

use App\Models\User;

trait CommonAuthTrait
{
    protected function createUser(): User
    {
        return User::factory()->create();
    }

    protected function getBodyToCatchToken(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => 'password'
        ];
    }

    protected function catchTokenAuth(): string
    {
        $user = $this->createUser();
        $body = $this->getBodyToCatchToken($user);
        $response = $this->postJson('/api/auth/login/', $body)->getContent();
        return json_decode($response, true)['auth']['token'];
    }
}
