<?php

test('a guest cannot update a task', function () {
    $user = App\Models\User::factory()->create();
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->put(route('tasks.update', $task), [
        'name' => 'updated',
        'description' => $task->description,
        'state' => App\Enums\State::TODO->value,
        'priority' => App\Enums\Priority::HIGH->value,
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => 'updated',
    ]);
});

test('a user can update a task', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);
    
    $response = $this->put(route('tasks.update', $task), [
        'name' => 'updated',
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
    ]);
    
    $response->assertRedirect('/tasks');
    $response->assertSessionHas('success', 'Task was edited successfully.');
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => 'updated'
    ]);
});

test('a user cannot update a task without name', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newDescription = fake()->paragraph();
    $response = $this->put(route('tasks.update', $task), [
        'description' => $newDescription,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
    ]);

    $response->assertSessionHasErrors(['name']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'description' => $newDescription,
    ]);
});

test('a user cannot update a task without description', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newName = fake()->word();
    $response = $this->put(route('tasks.update', $task), [
        'name' => $newName,
        'state' => $task->state->value,
        'priority' => $task->priority->value,
    ]);

    $response->assertSessionHasErrors(['description']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => $newName,
    ]);
});

test('a user cannot update a task without state', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newName = fake()->word();
    $response = $this->put(route('tasks.update', $task), [
        'name' => $newName,
        'description' => $task->description,
        'priority' => $task->priority->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => $newName,
    ]);
});

test('a user cannot update a task without priority', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newName = fake()->word();
    $response = $this->put(route('tasks.update', $task), [
        'name' => $newName,
        'description' => $task->description,
        'state' => $task->state->value,
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => $newName,
    ]);
});

test('a user cannot update a task with invalid state', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newName = fake()->word();
    $response = $this->put(route('tasks.update', $task), [
        'name' => $newName,
        'description' => $task->description,
        'state' => 'invalid state',
        'priority' => $task->priority->value,
    ]);

    $response->assertSessionHasErrors(['state']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => $newName,
    ]);
});

test('a user cannot update a task with invalid priority', function () {
    $user = App\Models\User::factory()->create();
    $this->actingAs($user);
    $task = App\Models\Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $newName = fake()->word();
    $response = $this->put(route('tasks.update', $task), [
        'name' => $newName,
        'description' => $task->description,
        'state' => $task->state->value,
        'priority' => 'invalid priority',
    ]);

    $response->assertSessionHasErrors(['priority']);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
        'name' => $newName,
    ]);
});
