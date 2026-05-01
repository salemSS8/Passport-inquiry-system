<?php

use App\Models\PassportApplication;
use App\Models\User;
use App\Models\Branch;
use App\Actions\Passport\CreateApplicationAction;
use App\Services\SearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an admin can create a passport application with all fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $branch = Branch::factory()->create();
    
    $data = [
        'full_name' => 'Salem Mohammed',
        'mother_name' => 'Fatima Ali',
        'national_id' => '1234567890',
        'date_of_birth' => '1990-01-01',
        'gender' => 'male',
        'address' => 'Sana\'a, Yemen',
        'branch_id' => $branch->id,
        'pickup_branch_id' => $branch->id,
        'user_id' => $admin->id,
    ];

    $action = app(CreateApplicationAction::class);
    $application = $action->execute($data);

    expect($application->full_name)->toBe('Salem Mohammed')
        ->and($application->mother_name)->toBe('Fatima Ali')
        ->and($application->serial_number)->not->toBeNull()
        ->and($application->tracking_number)->not->toBeNull()
        ->and($application->status)->toBe('pending');

    $this->assertDatabaseHas('status_updates', [
        'passport_application_id' => $application->id,
        'status' => 'pending'
    ]);
});

test('a citizen can search for their application using any identifier', function () {
    $application = PassportApplication::factory()->create([
        'serial_number' => 'SER-12345',
        'national_id' => 'NAT-67890',
        'tracking_number' => 'TRK-ABCDE'
    ]);

    $searchService = app(SearchService::class);

    // Search by Serial Number
    $result = $searchService->findForInquiry('SER-12345');
    expect($result->id)->toBe($application->id);

    // Search by National ID
    $result = $searchService->findForInquiry('NAT-67890');
    expect($result->id)->toBe($application->id);

    // Search by Tracking Number
    $result = $searchService->findForInquiry('TRK-ABCDE');
    expect($result->id)->toBe($application->id);
});

test('public inquiry result shows the tracking timeline', function () {
    $application = PassportApplication::factory()->create();
    
    // Add multiple status updates
    $application->statusUpdates()->create([
        'status' => 'processing',
        'comment' => 'Being processed',
        'updated_by' => User::factory()->create()->id
    ]);

    $response = $this->get(route('inquiry.show', ['identifier' => $application->serial_number]));

    $response->assertStatus(200)
        ->assertViewIs('inquiry.show')
        ->assertSee('processing')
        ->assertSee('Being processed');
});
