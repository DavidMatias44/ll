<?php

use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->for($this->user)->create();
});

test('DELETE method should not delete a task without correct user association', function () {
    $invalidUserId = 1234;

    $response = $this->deleteJson("/api/users/{$invalidUserId}/tasks/{$this->task->id}");

    $response->assertStatus(404);
});

test('DELETE method should delete a task owned by certain user', function () {
    $response = $this->deleteJson("/api/users/{$this->user->id}/tasks/{$this->task->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('tasks', [
        'name' => $this->task->name,
        'user_id' => $this->user->id,
    ]);
});
