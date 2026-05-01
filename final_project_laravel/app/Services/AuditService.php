<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Log an administrative action.
     */
    public function log(int $userId, string $action, ?string $modelType = null, ?int $modelId = null, ?array $changes = null): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'ip_address' => Request::ip()
        ]);
    }
}
