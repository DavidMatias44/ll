<?php

beforeEach(function () {
    $this->user = App\Models\User::factory()->create();
    $this->otherUser = App\Models\User::factory()->create();
    $this->task = App\Models\Task::factory()->for($this->otherUser)->create();
});

test('a user can only edit their own tasks', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
    ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Update test',
        'user_id' => $this->otherUser->id,
    ]);
});

test('a user can only see their own tasks information', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('tasks.show', $this->task));

    $response->assertForbidden();
});

test('a user can only delete their own tasks', function () {
    $this->actingAs($this->user);

    $response = $this->delete(route('tasks.delete', $this->task));

    $response->assertForbidden();
});
