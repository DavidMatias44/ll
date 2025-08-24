<?php

use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->for($this->user)->create();
});

test('PUT method should update a task owned by certain user', function () {
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task owned if there is no name', function () {
    $newData = [
        'description' => 'Put test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name']);
    $this->assertDatabaseMissing('tasks', [
        'description' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task if there is no description', function () {
    $newData = [
        'name' => 'Put test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task if there is no state', function () {
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task owned if there is an invalid state', function () {
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'state' => 'invalid',
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task if there is no priority', function () {
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'state' => App\Enums\State::TODO->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});

test('PUT method should not update a task if there is an invalid priority', function () {
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'state' => App\Enums\State::TODO->value,
        'priority' => 'invalid',
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$this->task->id}", $newData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Put test',
        'user_id' => $this->user->id,
    ]);
});
