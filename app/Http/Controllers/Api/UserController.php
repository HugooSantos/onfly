<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(UserRequest $userRequest): object
    {
        $user = $userRequest->toArray();
        User::create($user);
        return $this->getSucessUserCreateResponse();
    }

    private function getSucessUserCreateResponse(): object
    {
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Criação do usuário feita com sucesso',
        ], 201);
    }
}