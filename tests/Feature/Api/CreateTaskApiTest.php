<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
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

test('POST method should not create a new task if there is no name', function () {
    $data = [
        'description' => 'Post test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name']);
    $this->assertDatabaseMissing('tasks', [
        'description' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});

test('POST method should not create a new task if there is no description', function () {
    $data = [
        'name' => 'Post test',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['description']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});

test('POST method should not create a new task if there is no state', function () {
    $data = [
        'name' => 'Post test',
        'description' => 'Post test',
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});

test('POST method should not create a new task if there is an invalid state', function () {
    $data = [
        'name' => 'Post test',
        'description' => 'Post test',
        'state' => 'invalid',
        'priority' => App\Enums\Priority::HIGH->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});

test('POST method should not create a new task if there is no priority', function () {
    $data = [
        'name' => 'Post test',
        'description' => 'Post test',
        'state' => App\Enums\State::TODO->value,
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});

test('POST method should not create a new task if there is an invalid priority', function () {
    $data = [
        'name' => 'Post test',
        'description' => 'Post test',
        'state' => App\Enums\State::TODO->value,
        'priority' => 'invalid',
    ];

    $response = $this->postJson("/api/users/{$this->user->id}/tasks", $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Post test',
        'user_id' => $this->user->id,
    ]);
});
