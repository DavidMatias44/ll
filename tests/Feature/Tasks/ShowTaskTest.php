<?php

test('a guest cannot see a task', function () {
    $user = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('tasks.show', $task));

    $response->assertRedirect('/login');
});

test('a user can see a task', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('tasks.show', $task));

    $response->assertStatus(200);
});

test('a user gets the correct data when seeing a task', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('tasks.show', $task));

    $response->assertStatus(200);
    $response->assertViewHas('task', function($viewTask) use ($task) {
        return $viewTask->id == $task->id;
    });
    $response->assertSeeText($task->name);
    $response->assertSeeText($task->description);
    $response->assertSeeText($task->state->label());
    $response->assertSeeText($task->priority->label());
});
