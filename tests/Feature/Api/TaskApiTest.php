<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('GET method should list all tasks owned by certain user', function () {
    $otherUser = User::factory()->create();
    $tasks = Task::factory(5)->for($this->user)->create();
    Task::factory(3)->for($otherUser)->create();

    $response = $this->getJson("/api/users/{$this->user->id}/tasks");

    $response->assertStatus(200);
    $response->assertJsonCount(5, 'data');
});

test('POST method should create a new task owned by certain user', function () {
    $data = [
        'name' => 'Post test',
        'description' => 'Post test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(201);
    $this->assertDatabaseHas('tasks', $data);
});

test('PUT method should update a task owned by certain user', function () {
    $task = Task::factory()->for($this->user)->create();
    $newData = [
        'name' => 'Put test',
        'description' => 'Put test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->putJson("/api/users/{$this->user->id}/tasks/{$task->id}", $newData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('tasks', $newData);
});

test('DELETE method should delete a task owned by certain user', function () {
    $task = Task::factory()->for($this->user)->create();

    $response = $this->deleteJson("/api/users/{$this->user->id}/tasks/{$task->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('tasks', [
        'name' => $task->name,
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
        'user_id' => $this->user->id,
    ]);
});
