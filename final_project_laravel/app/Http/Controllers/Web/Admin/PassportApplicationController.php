<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\PassportApplication;
use App\Models\Branch;
use App\Actions\Passport\CreateApplicationAction;
use App\Actions\Passport\UpdateStatusAction;
use App\Services\SearchService;
use App\Services\MediaService;
use Illuminate\Http\Request;

class PassportApplicationController extends Controller
{
    protected $searchService;
    protected $mediaService;

    public function __construct(
        SearchService $searchService,
        MediaService $mediaService
    ) {
        $this->searchService = $searchService;
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search');
        if ($query) {
            $applications = $this->searchService->search($query);
        } else {
            $applications = PassportApplication::with(['branch', 'user'])->latest()->paginate(15);
        }

        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('admin.applications.create', compact('branches'));
    }

    public function store(Request $request, CreateApplicationAction $createAction)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|max:20',
            'branch_id' => 'required|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->mediaService->uploadPhoto($request->file('photo'));
        }

        $createAction->execute($data);

        return redirect()->route('admin.applications.index')->with('success', 'Application created successfully.');
    }

    public function updateStatus(Request $request, PassportApplication $application, UpdateStatusAction $updateAction)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,ready,collected',
            'comment' => 'nullable|string',
        ]);

        $updateAction->execute(
            $application,
            $data['status'],
            $data['comment'] ?? "Status changed to {$data['status']}.",
            auth()->id()
        );

        return back()->with('success', 'Status updated successfully.');
    }
}
