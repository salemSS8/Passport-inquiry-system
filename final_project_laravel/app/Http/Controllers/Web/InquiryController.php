<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index()
    {
        return view('inquiry.index');
    }

    public function show(Request $request)
    {
        $identifier = $request->input('identifier');
        
        if (!$identifier) {
            return redirect()->route('inquiry.index');
        }

        $application = $this->searchService->findForInquiry($identifier);

        return view('inquiry.show', compact('application', 'identifier'));
    }
}
