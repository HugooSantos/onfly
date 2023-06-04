<?php

use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/users', [UserController::class, 'createUser']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('expenses', ExpenseController::class);
});
