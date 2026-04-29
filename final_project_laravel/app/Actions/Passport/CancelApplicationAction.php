<?php

namespace App\Actions\Passport;

use App\Events\ApplicationCancelled;
use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use Illuminate\Support\Facades\DB;

class CancelApplicationAction
{
    /**
     * Execute the action.
     */
    public function execute(PassportApplication $application, string $reason, int $updatedBy): PassportApplication
    {
        return DB::transaction(function () use ($application, $reason, $updatedBy) {
            $oldStatus = $application->status;
            
            $application->update(['status' => 'cancelled']);

            $statusUpdate = StatusUpdate::create([
                'passport_application_id' => $application->id,
                'status' => 'cancelled',
                'comment' => $reason,
                'updated_by' => $updatedBy
            ]);

            event(new ApplicationCancelled($application, $statusUpdate, $oldStatus));

            return $application;
        });
    }
}
