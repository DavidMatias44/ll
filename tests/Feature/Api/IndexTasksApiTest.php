<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->user = User::factory()->create();
    Task::factory(5)->for($this->user)->create();
});

test('GET method should not list tasks without correct user association', function () {
    $invalidUserId = 1234;

    $response = $this->getJson("/api/users/{$invalidUserId}/tasks");

    $response->assertStatus(404);
});

test('GET method should list all tasks owned by certain user', function () {
    $otherUser = User::factory()->create();
    Task::factory(3)->for($otherUser)->create();

    $response = $this->getJson("/api/users/{$this->user->id}/tasks");

    $response->assertStatus(200);
    $response->assertJsonCount(5, 'data');
});

test('GET method should list all tasks and pagination links', function () {
    Task::factory()->for($this->user)->create();

    $response = $this->getJson("/api/users/{$this->user->id}/tasks");

    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('links.first')
            ->has('links.last')
            ->has('links.prev')
            ->has('links.next')
            ->has('meta.current_page')
            ->has('meta.from')
            ->has('meta.last_page')
            ->has('meta.links')
            ->has('meta.path')
            ->has('meta.per_page')
            ->has('meta.to')
            ->has('meta.total')
            ->etc()
    );
});
