<?php

beforeEach(function () {
    $this->user = App\Models\User::factory()->create();
    $this->task = App\Models\Task::factory()->for($this->user)->create();
});

test('a guest cannot update a task', function () {
    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'updated',
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'updated',
    ]);
});

test('a user can update a task', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'updated',
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
    ]);
    
    $response->assertRedirect('/tasks');
    $response->assertSessionHas('success', 'Task was edited successfully.');
    $this->assertDatabaseHas('tasks', [
        'id' => $this->task->id,
        'name' => 'updated'
    ]);
});

test('a user cannot update a task without name', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'description' => 'Update test',
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
    ]);

    $response->assertSessionHasErrors(['name']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'description' => 'Update test',
    ]);
});

test('a user cannot update a task without description', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'state' => $this->task->state->value,
        'priority' => $this->task->priority->value,
    ]);

    $response->assertSessionHasErrors(['description']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'Update test',
    ]);
});

test('a user cannot update a task without state', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'description' => $this->task->description,
        'priority' => $this->task->priority->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'Update test',
    ]);
});

test('a user cannot update a task without priority', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'description' => $this->task->description,
        'state' => $this->task->state->value,
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'Update test',
    ]);
});

test('a user cannot update a task with invalid state', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'description' => $this->task->description,
        'state' => 'invalid state',
        'priority' => $this->task->priority->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'Update test',
    ]);
});

test('a user cannot update a task with invalid priority', function () {
    $this->actingAs($this->user);

    $response = $this->put(route('tasks.update', $this->task), [
        'name' => 'Update test',
        'description' => $this->task->description,
        'state' => $this->task->state->value,
        'priority' => 'invalid priority',
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $this->task->id,
        'name' => 'Update test',
    ]);
});
