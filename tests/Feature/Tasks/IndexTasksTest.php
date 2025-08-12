<?php

test('a guest cannot list tasks', function () {
    $user = App\Models\User::factory()->create();
    $tasks = App\Models\Task::factory(5)->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertRedirect('/login');
});

test('a user can list their own tasks', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $otherUser = App\Models\User::factory()->create();

    $tasks = App\Models\Task::factory(2)->create([
        'user_id' => $user->id,
    ]);
    App\Models\Task::factory(2)->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertStatus(200);
    $response->assertViewHas('tasks', function ($viewTasks) use ($tasks) {
        return $viewTasks->count() == 2 && $viewTasks->contains($tasks[0]);
    });
});

test('a user can only see 5 tasks per page', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $tasks = App\Models\Task::factory(10)->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertStatus(200);
    $response->assertViewHas('tasks', function ($viewTasks) use ($tasks) {
        return $viewTasks->count() == 5 && $viewTasks->contains($tasks[0] && !$viewTasks->contains($tasks[5]));
    });
});

test('a user can see paginator links when there is more than 5 tasks', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $tasks = App\Models\Task::factory(10)->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get('/tasks');

    $response->assertStatus(200);
    $response->assertViewHas('tasks', function ($viewTasks) {
        return $viewTasks instanceof \Illuminate\Pagination\LengthAwarePaginator;
    });
    $response->assertSee('paginator');
});
