<?php

use App\Models\User;

test("it creates a new idea", function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit("/ideas")
        ->click("@create-idea-button")
        ->fill("title", "My First Idea")
        ->click("@button-status-in_progress")
        ->click("@button-modal-create")
        ->assertPathIs('/ideas');

    expect($user->ideas()->count())->toBe(1);

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea',
        'status' => 'in_progress'
    ]);
});
