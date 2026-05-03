<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PassportApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class PassportTrackingController extends Controller
{
    /**
     * Track a passport application by its serial number.
     *
     * @param string $serial_number
     * @return JsonResponse
     */
    public function track(string $serial_number): JsonResponse
    {
        try {
            // Find application by serial number, eager load branch and latest status updates
            $application = PassportApplication::with([
                'branch',
                'statusUpdates' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])->where('serial_number', $serial_number)->first();

            // If not found, return 404 response
            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'عذراً، الرقم التسلسلي غير موجود في النظام.'
                ], 404);
            }

            // Return success response with application data
            return response()->json([
                'success' => true,
                'data' => $application
            ], 200);

        } catch (Exception $e) {
            // Handle unexpected server errors
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الخادم. يرجى المحاولة لاحقاً.',
                // 'error' => $e->getMessage() // Optional: Include error details for debugging
            ], 500);
        }
    }
}
