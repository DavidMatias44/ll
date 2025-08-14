<?php

beforeEach(function () {
    $this->user = App\Models\User::factory()->create();
    $this->task = App\Models\Task::factory()->for($this->user)->create();
});

test('a guest cannot see a task', function () {
    $response = $this->get(route('tasks.show', $this->task));

    $response->assertRedirect('/login');
});

test('a user can see a task', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('tasks.show', $this->task));

    $response->assertOk();
});

test('a user gets the correct data when seeing a task', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('tasks.show', $this->task));

    $response->assertOk();
    $response->assertViewHas('task', function ($viewTask) {
        return $viewTask->id == $this->task->id;
    });
    $response->assertSeeText($this->task->name);
    $response->assertSeeText($this->task->description);
    $response->assertSeeText($this->task->state->label());
    $response->assertSeeText($this->task->priority->label());
});
