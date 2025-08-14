<?php

beforeEach(function () {
    $this->user = App\Models\User::factory()->create();
    $this->task = App\Models\Task::factory()->for($this->user)->create();
});

test('a guest cannot delete a task', function () {
    $response = $this->delete(route('tasks.delete', $this->task));

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('tasks', [
        'name' => $this->task->name,
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
        'user_id' => $this->task->user_id,
    ]);
});

test('a user can delete a task', function () {
    $this->actingAs($this->user);

    $response = $this->delete(route('tasks.delete', $this->task));

    $response->assertRedirect('/tasks');
    $this->assertDatabaseMissing('tasks', [
        'name' => $this->task->name,
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
        'user_id' => $this->task->user_id,
    ]);
});
