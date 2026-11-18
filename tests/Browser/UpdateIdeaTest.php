<?php

use App\Models\Idea;
use App\Models\User;

test('it updates an idea', function () {
    /** @var User */
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->for($user)->create();

    visit(route('ideas.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'My First Idea')
        ->click('@button-status-in_progress')
        ->fill('description', 'Description')
        ->fill('@input-new-link', 'http://example.com')
        ->click('@button-add-link')
        ->fill('@input-new-step', 'Step 1')
        ->click('@button-add-step')
        ->click('@button-modal-create')
        ->assertRoute('ideas.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea',
        'status' => 'in_progress',
        'description' => 'Description',
        'links' => [ $idea->links[0], 'http://example.com' ],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
