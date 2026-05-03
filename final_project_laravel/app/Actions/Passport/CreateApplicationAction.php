<?php

namespace App\Actions\Passport;

use App\Models\PassportApplication;
use App\Models\StatusUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateApplicationAction
{
    /**
     * Execute the action.
     */
    public function execute(array $data): PassportApplication
    {
        // Defensive fix: Map Arabic status labels back to English keys if sent
        $statusMap = array_flip(PassportApplication::STATUS_LABELS);
        if (isset($data['status']) && isset($statusMap[$data['status']])) {
            $data['status'] = $statusMap[$data['status']];
        }

        return DB::transaction(function () use ($data) {
            // Duplicate Entry Check: Reject if there is an active application for this National ID
            $exists = PassportApplication::where('national_id', $data['national_id'])
                ->where('status', '!=', 'collected')
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'national_id' => 'يوجد طلب نشط مسبقاً لهذا الرقم الوطني.'
                ]);
            }

            $data['tracking_number'] ??= 'TRK-'.strtoupper(Str::random(10));
            $data['serial_number'] ??= 'SER-'.strtoupper(Str::random(8));
            $data['status'] ??= 'pending';

            $application = PassportApplication::create($data);

            // Initial status update
            StatusUpdate::create([
                'passport_application_id' => $application->id,
                'status' => $data['status'],
                'comment' => 'تم استلام الطلب وبدء المعالجة.',
                'updated_by' => $data['user_id'],
            ]);

            return $application;
        });
    }
}
