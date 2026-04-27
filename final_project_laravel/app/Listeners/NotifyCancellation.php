<?php

namespace App\Listeners;

use App\Events\ApplicationCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyCancellation implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ApplicationCancelled $event): void
    {
        Log::warning("URGENT: Application {$event->application->tracking_number} for {$event->application->full_name} has been CANCELLED. Reason: {$event->statusUpdate->comment}");
    }
}
