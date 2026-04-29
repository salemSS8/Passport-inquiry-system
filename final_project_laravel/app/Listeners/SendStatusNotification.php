<?php

namespace App\Listeners;

use App\Events\ApplicationStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendStatusNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ApplicationStatusUpdated $event): void
    {
        // Mock notification logic
        $citizenName = $event->application->full_name;
        $newStatus = $event->application->status;
        $trackingNumber = $event->application->tracking_number;

        Log::info("SMS/Email sent to {$citizenName}: Your passport application ({$trackingNumber}) is now: {$newStatus}.");
    }
}
