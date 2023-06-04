<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\AuthenticationResponseTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use AuthenticationResponseTrait;

    public function login(AuthRequest $authRequest): JsonResponse
    {
        $credentials = $authRequest->toArray();
        $token = Auth::attempt($credentials);

        if ($token) {
            return $this->getAuthenticatedResponse($token);
        }

        return $this->getFailedAuthenticatedResponse();
    }
}