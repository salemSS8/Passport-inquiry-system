<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Passport\CreateApplicationAction;
use App\Actions\Passport\UpdateStatusAction;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PassportApplication;
use App\Services\MediaService;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $status = $request->input('status');

        $applicationsQuery = PassportApplication::with(['branch', 'user']);

        if ($query) {
            $applicationsQuery->where(function ($q) use ($query) {
                $q->where('full_name', 'LIKE', "%{$query}%")
                    ->orWhere('tracking_number', 'LIKE', "%{$query}%")
                    ->orWhere('serial_number', 'LIKE', "%{$query}%")
                    ->orWhere('national_id', 'LIKE', "%{$query}%");
            });
        }

        if ($status) {
            $applicationsQuery->where('status', $status);
        }

        $applications = $applicationsQuery->latest()->paginate(15)->withQueryString();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(PassportApplication $application)
    {
        $application->load(['branch', 'pickupBranch', 'statusUpdates.updater']);

        return view('admin.applications.show', compact('application'));
    }

    public function edit(PassportApplication $application)
    {
        // Status Locking: Prevent editing if ready or collected
        if (in_array($application->status, ['ready', 'collected', 'جاهز للاستلام', 'تم التسليم'])) {
            return redirect()->route('admin.applications.index')
                ->with('error', 'لا يمكن تعديل الطلب بعد وصوله لمرحلة الجاهزية أو التسليم.');
        }

        $branches = Branch::all();

        return view('admin.applications.edit', compact('application', 'branches'));
    }

    public function update(Request $request, PassportApplication $application)
    {
        // Status Locking: Prevent update if ready or collected
        if (in_array($application->status, ['ready', 'collected', 'جاهز للاستلام', 'تم التسليم'])) {
            return redirect()->route('admin.applications.index')
                ->with('error', 'لا يمكن تعديل بيانات الطلب في هذه المرحلة.');
        }

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'national_id' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'pickup_branch_id' => 'nullable|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->mediaService->uploadPhoto($request->file('photo'));
        }

        $application->update($data);

        return redirect()->route('admin.applications.index')->with('success', 'Application updated successfully.');
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
            'mother_name' => 'nullable|string|max:255',
            'national_id' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'pickup_branch_id' => 'nullable|exists:branches,id',
            'status' => 'nullable|in:pending,processing,ready,collected,قيد الانتظار,جاري المعالجة,جاهز للاستلام,تم التسليم',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->mediaService->uploadPhoto($request->file('photo'));
        }

        try {
            $createAction->execute($data);
        } catch (\Exception $e) {
            // Clean up image if database transaction fails
            if (isset($data['photo_path'])) {
                Storage::delete($data['photo_path']);
            }
            throw $e;
        }

        return redirect()->route('admin.applications.index')->with('success', 'Application created successfully.');
    }

    public function updateStatus(Request $request, PassportApplication $application, UpdateStatusAction $updateAction)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,ready,collected,cancelled,archived,قيد الانتظار,جاري المعالجة,جاهز للاستلام,تم التسليم,ملغي,مؤرشف',
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
