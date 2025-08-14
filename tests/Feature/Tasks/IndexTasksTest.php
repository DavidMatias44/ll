<?php

use App\Models\User;
use App\Models\Task;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('a guest cannot list tasks', function () {
    $tasks = Task::factory(5)->for($this->user)->create();

    $response = $this->get('/tasks');

    $response->assertRedirect('/login');
});

test('a user can list their own tasks', function () {
    $this->actingAs($this->user);
    $tasks = Task::factory(2)->for($this->user)->create();
    $otherUser = User::factory()->create();
    Task::factory(2)->for($otherUser)->create();

    $response = $this->get('/tasks');

    $response->assertOk();
    $response->assertViewHas('tasks', function ($viewTasks) use ($tasks) {
        return $viewTasks->count() == 2 && $viewTasks->contains($tasks[0]);
    });
});

test('a user can only see 5 tasks per page', function () {
    $this->actingAs($this->user);
    $tasks = Task::factory(10)->for($this->user)->create();

    $response = $this->get('/tasks');

    $response->assertOk();
    $response->assertViewHas('tasks', function ($viewTasks) use ($tasks) {
        return $viewTasks->count() == 5 && $viewTasks->contains($tasks[0] && !$viewTasks->contains($tasks[5]));
    });
});

test('a user can see paginator links when there is more than 5 tasks', function () {
    $this->actingAs($this->user);
    $tasks = Task::factory(10)->for($this->user)->create();

    $response = $this->get('/tasks');

    $response->assertOk();
    $response->assertViewHas('tasks', function ($viewTasks) {
        return $viewTasks instanceof \Illuminate\Pagination\LengthAwarePaginator;
    });
    $response->assertSee('paginator');
});
