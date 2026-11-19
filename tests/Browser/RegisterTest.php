<?php

use Illuminate\Support\Facades\Auth;

test('register a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'email@testmail.com')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'email@testmail.com',
    ]);
});
