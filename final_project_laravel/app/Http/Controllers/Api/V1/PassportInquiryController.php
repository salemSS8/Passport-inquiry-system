<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PassportResource;
use App\Services\SearchService;

class PassportInquiryController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function show(string $identifier)
    {
        $application = $this->searchService->findForInquiry($identifier);

        if (!$application) {
            return response()->json(['message' => 'Passport application not found.'], 404);
        }

        return new PassportResource($application);
    }
}
