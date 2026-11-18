<?php

use App\Models\User;

test('it creates a new idea', function () {
    /** @var User */
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'My First Idea')
        ->click('@button-status-in_progress')
        ->fill('description', 'Description')
        ->fill('@input-new-link', 'http://example.com')
        ->click('@button-add-link')
        ->fill('@input-new-link', 'http://laravel.com')
        ->click('@button-add-link')
        ->click('@button-modal-create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->count())->toBe(1);

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea',
        'status' => 'in_progress',
        'description' => 'Description',
        'links' => ['http://example.com', 'http://laravel.com'],
    ]);
});
