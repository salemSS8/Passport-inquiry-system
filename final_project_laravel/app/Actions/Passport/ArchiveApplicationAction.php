<?php

namespace App\Actions\Passport;

use App\Events\ApplicationArchived;
use App\Models\PassportApplication;
use Illuminate\Support\Facades\DB;

class ArchiveApplicationAction
{
    /**
     * Execute the action.
     */
    public function execute(PassportApplication $application, int $updatedBy): void
    {
        DB::transaction(function () use ($application, $updatedBy) {
            // Logic for archiving (e.g., moving to an archive table or just tagging)
            // For this implementation, we assume we just tag it and trigger cleanup.
            
            event(new ApplicationArchived($application, $updatedBy));
            
            // In a real system, you might delete the record from main table 
            // after moving it to an archive storage.
        });
    }
}
