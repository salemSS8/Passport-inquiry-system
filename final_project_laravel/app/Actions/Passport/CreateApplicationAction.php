<?php

namespace App\Actions\Passport;

use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateApplicationAction
{
    /**
     * Execute the action.
     */
    public function execute(array $data): PassportApplication
    {
        return DB::transaction(function () use ($data) {
            $data['tracking_number'] = 'TRK-' . strtoupper(Str::random(10));
            $data['serial_number'] = 'SER-' . strtoupper(Str::random(8));
            
            $application = PassportApplication::create($data);

            // Initial status update
            StatusUpdate::create([
                'passport_application_id' => $application->id,
                'status' => 'pending',
                'comment' => 'Application submitted.',
                'updated_by' => $data['user_id']
            ]);

            return $application;
        });
    }
}
