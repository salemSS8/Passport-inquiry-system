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
        // Defensive fix: Map Arabic status labels back to English keys if sent
        $statusMap = array_flip(PassportApplication::STATUS_LABELS);
        if (isset($statusMap[$status])) {
            $status = $statusMap[$status];
        }

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
