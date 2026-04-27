<?php

use App\Models\User;
use App\Models\PassportApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can login via api', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['user', 'token']);
});

test('citizen can inquire passport status via tracking number', function () {
    $application = PassportApplication::factory()->create([
        'tracking_number' => 'TRK-TEST123',
        'status' => 'processing',
    ]);

    $response = $this->getJson('/api/v1/inquiry/TRK-TEST123');

    $response->assertStatus(200)
        ->assertJsonPath('data.status', 'processing')
        ->assertJsonPath('data.tracking_number', 'TRK-TEST123');
});

test('citizen can inquire passport status via national id', function () {
    $application = PassportApplication::factory()->create([
        'national_id' => '1234567890',
        'status' => 'ready',
    ]);

    $response = $this->getJson('/api/v1/inquiry/1234567890');

    $response->assertStatus(200)
        ->assertJsonPath('data.status', 'ready');
});
