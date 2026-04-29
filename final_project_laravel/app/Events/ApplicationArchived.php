<?php

namespace App\Events;

use App\Models\PassportApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationArchived
{
    use Dispatchable, SerializesModels;

    public $application;
    public $updatedBy;

    public function __construct(PassportApplication $application, int $updatedBy)
    {
        $this->application = $application;
        $this->updatedBy = $updatedBy;
    }
}
