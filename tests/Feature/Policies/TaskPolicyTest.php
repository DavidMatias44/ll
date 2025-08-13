<?php

test('a user can only edit their own tasks', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $otherUser = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->put(route('tasks.update', $task), [
        'name' => 'Update test',
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Update test',
        'user_id' => $otherUser->id,
    ]);
});

test('a user can only see their own tasks information', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $otherUser = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->get(route('tasks.show', $task));

    $response->assertForbidden();
});

test('a user can only delete their own tasks', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $otherUser = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->delete(route('tasks.delete', $task));

    $response->assertForbidden();
});
