<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::first()->id,
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 100, 10000),
            'date' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }
}
