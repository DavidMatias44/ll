<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->for($this->user)->create();
});

test('GET method should not show task without correct user association', function () {
    $invalidUserId = 1234;

    $response = $this->get("/api/users/{$invalidUserId}/tasks/{$this->task->id}");

    $response->assertStatus(404);
});

test('GET method should show task owned by certain user', function () {
    $response = $this->get("/api/users/{$this->user->id}/tasks/{$this->task->id}");

    $response->assertStatus(200);
    $response->assertJson(fn (AssertableJson $json) => $json->where('data.name', $this->task->name)
        ->where('data.user_id', $this->user->id)
        ->etc()
    );
});
