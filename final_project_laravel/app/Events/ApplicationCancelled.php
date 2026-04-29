<?php

namespace App\Events;

use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationCancelled
{
    use Dispatchable, SerializesModels;

    public $application;
    public $statusUpdate;
    public $oldStatus;

    public function __construct(PassportApplication $application, StatusUpdate $statusUpdate, string $oldStatus)
    {
        $this->application = $application;
        $this->statusUpdate = $statusUpdate;
        $this->oldStatus = $oldStatus;
    }
}
