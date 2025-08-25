<?php

namespace Database\Factories;

use App\Enums\Tasks\Priority;
use App\Enums\Tasks\State;
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
