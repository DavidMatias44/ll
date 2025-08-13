<?php

test('a guest cannot delete a task', function () {
    $user = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->delete(route('tasks.delete', $task));

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('tasks', [
        'name' => $task->name,
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
        'user_id' => $task->user_id,
    ]);
});

test('a user can delete a task', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->delete(route('tasks.delete', $task));

    $response->assertRedirect('/tasks');
    $this->assertDatabaseMissing('tasks', [
        'name' => $task->name,
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
        'user_id' => $task->user_id,
    ]);  
});
