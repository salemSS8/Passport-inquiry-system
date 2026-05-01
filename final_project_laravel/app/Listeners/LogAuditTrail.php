<?php

namespace App\Listeners;

use App\Events\ApplicationStatusUpdated;
use App\Services\AuditService;
use App\Models\PassportApplication;

class LogAuditTrail
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationStatusUpdated $event): void
    {
        $this->auditService->log(
            $event->statusUpdate->updated_by,
            'update_status',
            PassportApplication::class,
            $event->application->id,
            [
                'old_status' => $event->oldStatus,
                'new_status' => $event->application->status,
                'comment' => $event->statusUpdate->comment
            ]
        );
    }
}
