<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PomodoroFactory extends Factory
{
    public function definition(): array
    {
        return [
            'time' => fake()->numberBetween(1, 25*60),
            'created_at' => fake()->dateTimeThisMonth(),
        ];
    }
}
