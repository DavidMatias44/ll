<?php

test('a guest cannot create a task', function () {
    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});

test('a user can create a task', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertRedirect('/tasks');
    $this->assertDatabaseHas('tasks', [
        'name' => 'Test Task',
        'user_id' => $user->id,
    ]);
});

test('a user cannot create a task without name', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'description' => 'Test Task description',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertSessionHasErrors(['name']);
    $this->assertDatabaseMissing('tasks', [
        'description' => 'Test Task description',
    ]);
});

test('a user cannot create a task without description', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertSessionHasErrors(['description']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});

test('a user cannot create a task without state', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});

test('a user cannot create a task without priority', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'state' => App\Enums\State::TODO->value,
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});

test('a user cannot create a task with invalid state', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'state' => 'invalid state',
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});

test('a user cannot create a task with invalid priority', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user); // User has to be authenticated to create a new task.

    $response = $this->post('/tasks/create', [
        'name' => 'Test Task',
        'description' => 'Test Task description',
        'state' => App\Enums\State::TODO->value,
        'priority' => 'invalid priority',
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'name' => 'Test Task',
    ]);
});
