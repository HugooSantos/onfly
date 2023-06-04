<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\AuthenticationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    use AuthenticationTrait;

    public function login(AuthRequest $authRequest): object
    {
        $credentials = $authRequest->toArray();
        $token = Auth::attempt($credentials);

        if ($token) {
            return $this->getAuthenticatedResponse($token);
        }

        return $this->getFailedAuthenticatedResponse();
    }
}