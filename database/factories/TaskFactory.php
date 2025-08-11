<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\State;
use App\Enums\Priority;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->paragraph(),
            'state' => State::TODO->value,
            'priority' => fake()->randomElement(Priority::cases())->value,
        ];
    }
}
