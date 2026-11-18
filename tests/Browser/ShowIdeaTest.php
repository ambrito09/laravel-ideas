<?php

use App\Models\Idea;
use App\Models\User;

test('requires authentication', function () {
    $idea = Idea::factory()->create();

    $this->get(route('ideas.show', $idea))->assertRedirectToRoute('login');
});

test('requires authorization', function () {
    $idea = Idea::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('ideas.show', $idea))->assertForbidden();
});
