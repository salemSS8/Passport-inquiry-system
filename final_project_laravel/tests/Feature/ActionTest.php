<?php

namespace Tests\Feature;

use App\Actions\Passport\CancelApplicationAction;
use App\Actions\Passport\ArchiveApplicationAction;
use App\Events\ApplicationCancelled;
use App\Events\ApplicationArchived;
use App\Models\PassportApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_cancel_application_action_updates_status_and_dispatches_event()
    {
        Event::fake();

        $user = User::factory()->create();
        $application = PassportApplication::factory()->create(['status' => 'pending']);
        $action = new CancelApplicationAction();

        $action->execute($application, 'Incorrect data submitted.', $user->id);

        $this->assertEquals('cancelled', $application->fresh()->status);
        Event::assertDispatched(ApplicationCancelled::class);
    }

    public function test_archive_application_action_dispatches_event()
    {
        Event::fake();

        $user = User::factory()->create();
        $application = PassportApplication::factory()->create(['status' => 'collected']);
        $action = new ArchiveApplicationAction();

        $action->execute($application, $user->id);

        Event::assertDispatched(ApplicationArchived::class);
    }
}
