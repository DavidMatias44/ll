<?php

namespace Database\Seeders;

use App\Models\Pomodoro;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPUnit\Framework\isEmpty;

class PomodoroSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            $num_session = 1;
            $tasks = Task::query()->whereUserId($user->id);

            Pomodoro::factory(random_int(5, 10))->create([
                'user_id' => $user->id,
                'task_id' => !isEmpty($tasks) && fake()->boolean(60) ? $tasks->random()->id : null,
                'num_session' => $num_session++,
            ]);
        }
    }
}
