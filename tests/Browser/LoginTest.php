<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

test('logs in a user', function () {
    User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
        'name' => 'Nuno Maduro',
        'email' => 'nuno@laravel.com',
        'password' => 'password',
    ]);

    visit('/login')
        ->fill('email', 'nuno@laravel.com')
        ->fill('password', 'password')
        ->click('@login-button')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'Nuno Maduro',
        'email' => 'nuno@laravel.com',
    ]);
});

test('logs out a user', function () {
    $user = User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
        'name' => 'Nuno Maduro',
        'email' => 'nuno@laravel.com',
        'password' => 'password',
    ]);

    // Auth::login($user);
    $this->actingAs($user);

    visit('/')
        ->click('@logout-button')
        ->assertPathIs('/login');

    $this->assertGuest();
});
