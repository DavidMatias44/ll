<?php

namespace Database\Factories;

use App\Enums\Priority;
use App\Enums\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'state' => State::TODO->value,
            'priority' => fake()->randomElement(Priority::cases())->value,
        ];
    }
}
