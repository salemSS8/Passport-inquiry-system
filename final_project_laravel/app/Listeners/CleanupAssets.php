<?php

namespace App\Listeners;

use App\Events\ApplicationArchived;
use App\Services\MediaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CleanupAssets implements ShouldQueue
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationArchived $event): void
    {
        if ($event->application->photo_path) {
            // Logic to move photo to cold storage or delete it if no longer needed
            Log::info("Archiving assets for application {$event->application->tracking_number}. Photo path: {$event->application->photo_path}");
            
            // Example: $this->mediaService->deletePhoto($event->application->photo_path);
        }
    }
}
