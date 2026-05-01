<?php

namespace App\Actions\Passport;

use App\Events\ApplicationStatusUpdated;
use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use Illuminate\Support\Facades\DB;

class UpdateStatusAction
{
    /**
     * Execute the action.
     */
    public function execute(PassportApplication $application, string $status, string $comment, int $updatedBy): PassportApplication
    {
        return DB::transaction(function () use ($application, $status, $comment, $updatedBy) {
            $oldStatus = $application->status;
            
            $application->update(['status' => $status]);

            $statusUpdate = StatusUpdate::create([
                'passport_application_id' => $application->id,
                'status' => $status,
                'comment' => $comment,
                'updated_by' => $updatedBy
            ]);

            // Dispatch event for decoupled side effects
            event(new ApplicationStatusUpdated($application, $statusUpdate, $oldStatus));

            return $application;
        });
    }
}
