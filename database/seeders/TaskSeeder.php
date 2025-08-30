<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        Task::factory(10)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            },
        ]);
    }
}
