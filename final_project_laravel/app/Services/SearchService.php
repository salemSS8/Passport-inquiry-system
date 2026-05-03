<?php

namespace App\Services;

use App\Models\PassportApplication;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    /**
     * Search for applications using multiple criteria.
     */
    public function search(string $query): Collection
    {
        return PassportApplication::where('serial_number', 'LIKE', "%{$query}%")
            ->orWhere('national_id', 'LIKE', "%{$query}%")
            ->orWhere('full_name', 'LIKE', "%{$query}%")
            ->orWhere('tracking_number', 'LIKE', "%{$query}%")
            ->with(['branch', 'user'])
            ->get();
    }

    /**
     * Find a single application by serial number (Private snippet key for citizens).
     */
    public function findForInquiry(string $identifier)
    {
        return PassportApplication::where('serial_number', $identifier)
            ->with(['branch', 'pickupBranch', 'statusUpdates' => function ($query) {
                $query->latest();
            }, 'statusUpdates.updater'])
            ->first();
    }
}
