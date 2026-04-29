<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuditService;

class EnsureSensitiveActionAuthorized
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user is Admin or Employee (basic role check)
        if (!$user || !in_array($user->role, ['admin', 'employee'])) {
            $this->auditService->log(
                $user ? $user->id : 0,
                'unauthorized_access_attempt',
                null,
                null,
                ['url' => $request->fullUrl()]
            );
            
            abort(403, 'Unauthorized action.');
        }

        // Additional checks could go here (e.g., check if employee belongs to the branch being accessed)

        return $next($request);
    }
}
