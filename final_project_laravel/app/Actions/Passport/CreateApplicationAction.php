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
        return DB::transaction(function () use ($data) {
            // Duplicate Entry Check: Reject if there is an active application for this National ID
            $exists = PassportApplication::where('national_id', $data['national_id'])
                ->whereNotIn('status', ['collected', 'تم التسليم'])
                ->exists();

            if ($exists) {
                throw new ValidationException(
                    Validator::make([], []),
                    ['national_id' => 'يوجد طلب نشط مسبقاً لهذا الرقم الوطني.']
                );
            }

            $data['tracking_number'] ??= 'TRK-'.strtoupper(Str::random(10));
            $data['serial_number'] ??= (string) random_int(1000000000, 9999999999);
            $data['status'] ??= 'قيد الانتظار';

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
