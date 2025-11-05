<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\User;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestSubmitted;
use App\Mail\RequestVerified;
use App\Mail\RequestApproved;
use App\Mail\RequestAssignedToLab;
use App\Mail\RequestAssignedToAnalyst;

class ServiceRequestController extends Controller
{
    /**
     * Display pending approval requests (for Admin/Direktur/Wakil Dir)
     */
    public function pendingApproval(Request $request)
    {
        $user = Auth::user();

        // Determine which status to show based on role
        $query = ServiceRequest::with(['user', 'service']);

        if ($user->hasRole('Super Admin') || $user->hasRole('TU & Keuangan')) {
            // Show pending (need verification)
            $query->where('status', 'pending');
        } elseif ($user->hasRole('Direktur')) {
            // Show verified (need approval)
            $query->where('status', 'verified');
        } elseif ($user->hasRole('Wakil Direktur')) {
            // Show approved (need assignment to lab)
            $query->where('status', 'approved');
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by SLA status
        if ($request->filled('sla_status')) {
            $now = now();
            if ($request->sla_status === 'overdue') {
                $query->where('created_at', '<', $now->copy()->subHours(24));
            } elseif ($request->sla_status === 'warning') {
                $query->whereBetween('created_at', [$now->copy()->subHours(24), $now->copy()->subHours(16)]);
            } elseif ($request->sla_status === 'ok') {
                $query->where('created_at', '>', $now->copy()->subHours(16));
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort by most urgent first (priority + created_at)
        $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'normal', 'low')")
              ->orderBy('created_at', 'asc');

        $requests = $query->paginate(15);
        $pendingCount = $requests->total();

        // Count overdue (> 24 hours)
        $statusForOverdue = 'pending';
        if ($user->hasRole('Super Admin') || $user->hasRole('TU & Keuangan')) {
            $statusForOverdue = 'pending';
        } elseif ($user->hasRole('Direktur')) {
            $statusForOverdue = 'verified';
        } elseif ($user->hasRole('Wakil Direktur')) {
            $statusForOverdue = 'approved';
        }

        $overdueCount = ServiceRequest::where('status', $statusForOverdue)
            ->where('created_at', '<', now()->subHours(24))
            ->count();

        return view('service-requests.pending-approval', compact('requests', 'pendingCount', 'overdueCount'));
    }

    /**
     * Display a listing of service requests
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['user', 'service', 'assignedTo']);

        // Filter by status
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->byService($request->service_id);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // User role-based filtering
        $user = Auth::user();
        if ($user->hasRole('Mahasiswa') || $user->hasRole('Dosen') || $user->hasRole('Peneliti Eksternal') || $user->hasRole('Industri/Umum')) {
            // Regular users only see their own requests
            $query->byUser($user->id);
        } elseif ($user->hasRole('Kepala Lab') || $user->hasRole('Anggota Lab')) {
            // Lab staff see requests assigned to them or their lab
            // For now, show all (will be refined with lab assignment later)
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $requests = $query->paginate(15);

        // Get filter options
        $services = Service::active()->orderBy('name')->get();
        $statuses = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'approved' => 'Disetujui',
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'testing' => 'Sedang Analisis',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];

        return view('service-requests.index', compact('requests', 'services', 'statuses'));
    }

    /**
     * Show the form for creating a new service request
     * Step 1: Select Service
     */
    public function create(Request $request)
    {
        $step = $request->get('step', 1);

        // Step 1: Select Service
        if ($step == 1) {
            $services = Service::active()->with('laboratory')->get();
            $draft = session('service_request_draft', []);
            return view('service-requests.create-step1', compact('services', 'draft'));
        }

        // Subsequent steps require service_id in session
        if (!session()->has('service_request_draft')) {
            return redirect()->route('service-requests.create')->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        $draft = session('service_request_draft');
        $service = Service::findOrFail($draft['service_id']);

        // Step 2: Sample Information
        if ($step == 2) {
            return view('service-requests.create-step2', compact('service', 'draft'));
        }

        // Step 3: Research Information
        if ($step == 3) {
            return view('service-requests.create-step3', compact('service', 'draft'));
        }

        // Step 4: Review & Submit
        if ($step == 4) {
            return view('service-requests.create-step4', compact('service', 'draft'));
        }

        return redirect()->route('service-requests.create');
    }

    /**
     * Store a newly created service request (handles all steps)
     */
    public function store(Request $request)
    {
        $step = $request->get('step', 1);

        // Step 1: Select Service & Basic Info
        if ($step == 1) {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_urgent' => 'boolean',
                'urgency_reason' => 'required_if:is_urgent,1|nullable|string',
            ]);

            // Store in session
            session(['service_request_draft' => $validated]);

            return redirect()->route('service-requests.create', ['step' => 2]);
        }

        // Step 2: Sample Information
        if ($step == 2) {
            $validated = $request->validate([
                'sample_count' => 'required|integer|min:1',
                'sample_type' => 'required|string|max:255',
                'sample_description' => 'required|string',
                'sample_preparation' => 'nullable|string',
            ]);

            // Merge with session data
            $draft = session('service_request_draft', []);
            session(['service_request_draft' => array_merge($draft, $validated)]);

            return redirect()->route('service-requests.create', ['step' => 3]);
        }

        // Step 3: Research Information
        if ($step == 3) {
            $validated = $request->validate([
                'research_title' => 'nullable|string|max:255',
                'research_objective' => 'nullable|string',
                'institution' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'supervisor_name' => 'nullable|string|max:255',
                'supervisor_contact' => 'nullable|string|max:255',
                'preferred_date' => 'nullable|date|after:today',
                'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB
            ]);

            // Handle file upload
            if ($request->hasFile('proposal_file')) {
                $path = $request->file('proposal_file')->store('service-requests/proposals', 'public');
                $validated['proposal_file'] = $path;
            }

            // Merge with session data
            $draft = session('service_request_draft', []);
            session(['service_request_draft' => array_merge($draft, $validated)]);

            return redirect()->route('service-requests.create', ['step' => 4]);
        }

        // Step 4: Final Submit
        if ($step == 4) {
            $draft = session('service_request_draft', []);

            if (empty($draft)) {
                return redirect()->route('service-requests.create')->with('error', 'Data permohonan tidak ditemukan. Silakan mulai ulang.');
            }

            // Add user_id and calculate estimated completion
            $draft['user_id'] = Auth::id();
            $draft['priority'] = isset($draft['is_urgent']) && $draft['is_urgent'] ? 'urgent' : 'standard';

            // Create the request
            $serviceRequest = ServiceRequest::create($draft);

            // Calculate and update estimated completion date
            $estimatedDate = $serviceRequest->calculateEstimatedCompletion();
            $serviceRequest->update(['estimated_completion_date' => $estimatedDate]);

            // Send email notification to user
            try {
                Mail::to($serviceRequest->user->email)->send(new RequestSubmitted($serviceRequest));
            } catch (\Exception $e) {
                \Log::error('Failed to send RequestSubmitted email: ' . $e->getMessage());
            }

            // Clear session
            session()->forget('service_request_draft');

            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('success', 'Permohonan layanan berhasil diajukan dengan nomor: ' . $serviceRequest->request_number);
        }

        return redirect()->route('service-requests.create');
    }

    /**
     * Display the specified service request
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['user', 'service.laboratory', 'assignedTo', 'verifiedBy', 'approvedBy']);

        // Increment view count
        $serviceRequest->incrementViewCount();

        // Get timeline events
        $timelineEvents = $serviceRequest->getTimelineEvents();

        // Check if user can view this request
        $user = Auth::user();
        if (!$user->hasRole(['Super Admin', 'Wakil Direktur Pelayanan', 'Wakil Direktur PM & TI', 'Kepala Lab', 'Anggota Lab', 'Sub Bagian TU & Keuangan'])) {
            if ($serviceRequest->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki akses untuk melihat permohonan ini.');
            }
        }

        return view('service-requests.show', compact('serviceRequest', 'timelineEvents'));
    }

    /**
     * Show the form for editing the specified service request
     * Only allowed if status is 'pending'
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        // Check if user owns this request
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit permohonan ini.');
        }

        // Check if request can be edited
        if (!$serviceRequest->canBeEdited()) {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Permohonan dengan status "' . $serviceRequest->status_label . '" tidak dapat diedit.');
        }

        $services = Service::active()->with('laboratory')->get();

        return view('service-requests.edit', compact('serviceRequest', 'services'));
    }

    /**
     * Update the specified service request
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        // Check if user owns this request
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit permohonan ini.');
        }

        // Check if request can be edited
        if (!$serviceRequest->canBeEdited()) {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Permohonan dengan status "' . $serviceRequest->status_label . '" tidak dapat diedit.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_urgent' => 'boolean',
            'urgency_reason' => 'required_if:is_urgent,1|nullable|string',
            'sample_count' => 'required|integer|min:1',
            'sample_type' => 'required|string|max:255',
            'sample_description' => 'required|string',
            'sample_preparation' => 'nullable|string',
            'research_title' => 'nullable|string|max:255',
            'research_objective' => 'nullable|string',
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'supervisor_contact' => 'nullable|string|max:255',
            'preferred_date' => 'nullable|date|after:today',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('proposal_file')) {
            // Delete old file
            if ($serviceRequest->proposal_file) {
                Storage::disk('public')->delete($serviceRequest->proposal_file);
            }
            $path = $request->file('proposal_file')->store('service-requests/proposals', 'public');
            $validated['proposal_file'] = $path;
        }

        // Update priority
        $validated['priority'] = isset($validated['is_urgent']) && $validated['is_urgent'] ? 'urgent' : 'standard';

        $serviceRequest->update($validated);

        // Recalculate estimated completion if service changed
        if ($serviceRequest->wasChanged('service_id') || $serviceRequest->wasChanged('is_urgent')) {
            $estimatedDate = $serviceRequest->calculateEstimatedCompletion();
            $serviceRequest->update(['estimated_completion_date' => $estimatedDate]);
        }

        return redirect()->route('service-requests.show', $serviceRequest)
            ->with('success', 'Permohonan layanan berhasil diperbarui.');
    }

    /**
     * Cancel the specified service request
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        // Check if user owns this request
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan permohonan ini.');
        }

        // Check if request can be cancelled
        if (!$serviceRequest->canBeCancelled()) {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Permohonan dengan status "' . $serviceRequest->status_label . '" tidak dapat dibatalkan.');
        }

        $serviceRequest->cancel();

        return redirect()->route('service-requests.index')
            ->with('success', 'Permohonan layanan berhasil dibatalkan.');
    }

    /**
     * Public tracking by request number
     */
    public function tracking(Request $request)
    {
        if ($request->method() === 'GET' && !$request->has('request_number')) {
            return view('service-requests.tracking');
        }

        $validated = $request->validate([
            'request_number' => 'required|string',
        ]);

        $serviceRequest = ServiceRequest::where('request_number', $validated['request_number'])
            ->with(['service.laboratory', 'user'])
            ->first();

        if (!$serviceRequest) {
            return back()->with('error', 'Nomor permohonan tidak ditemukan.');
        }

        // Return tracking result view (public, no auth required)
        return view('service-requests.tracking-result', compact('serviceRequest'));
    }

    /**
     * Admin: Verify request
     */
    public function verify(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'pending') {
            return back()->with('error', 'Hanya permohonan dengan status "Menunggu Verifikasi" yang dapat diverifikasi.');
        }

        $serviceRequest->markAsVerified(Auth::id());

        // Send email notification to Direktur
        try {
            $direktur = User::role('Direktur')->first();
            if ($direktur) {
                Mail::to($direktur->email)->send(new RequestVerified($serviceRequest));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send RequestVerified email: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan berhasil diverifikasi.');
    }

    /**
     * Director: Approve request
     */
    public function approve(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'verified') {
            return back()->with('error', 'Hanya permohonan dengan status "Terverifikasi" yang dapat disetujui.');
        }

        $serviceRequest->markAsApproved(Auth::id());

        // Send email notification to Wakil Direktur
        try {
            $wakilDir = User::role('Wakil Direktur')->first();
            if ($wakilDir) {
                Mail::to($wakilDir->email)->send(new RequestApproved($serviceRequest));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send RequestApproved email: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan berhasil disetujui.');
    }

    /**
     * Wakil Direktur: Assign to Laboratory
     */
    public function assignLab(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'approved') {
            return back()->with('error', 'Hanya permohonan dengan status "Disetujui" yang dapat ditugaskan ke laboratorium.');
        }

        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'assignment_notes' => 'nullable|string',
        ]);

        // Update laboratory assignment
        $serviceRequest->update([
            'assigned_to_lab_id' => $validated['laboratory_id'],
            'lab_assigned_at' => now(),
        ]);

        // Send email notification to Kepala Lab
        try {
            $laboratory = Laboratory::find($validated['laboratory_id']);
            if ($laboratory && $laboratory->head_user_id) {
                $kepalaLab = User::find($laboratory->head_user_id);
                if ($kepalaLab) {
                    Mail::to($kepalaLab->email)->send(new RequestAssignedToLab($serviceRequest));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send RequestAssignedToLab email: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan berhasil ditugaskan ke laboratorium. Kepala Lab akan menerima notifikasi.');
    }

    /**
     * Kepala Lab: Assign to analyst
     */
    public function assign(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'approved') {
            return back()->with('error', 'Hanya permohonan dengan status "Disetujui" yang dapat ditugaskan.');
        }

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'assignment_notes' => 'nullable|string',
        ]);

        $serviceRequest->assignTo($validated['assigned_to']);

        // Send email notification to analyst and user
        try {
            $analyst = User::find($validated['assigned_to']);
            if ($analyst) {
                Mail::to($analyst->email)->send(new RequestAssignedToAnalyst($serviceRequest, 'analyst'));
            }
            Mail::to($serviceRequest->user->email)->send(new RequestAssignedToAnalyst($serviceRequest, 'user'));
        } catch (\Exception $e) {
            \Log::error('Failed to send RequestAssignedToAnalyst email: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan berhasil ditugaskan ke analis.');
    }

    /**
     * Lab: Update status to in_progress
     */
    public function startProgress(ServiceRequest $serviceRequest)
    {
        if (!in_array($serviceRequest->status, ['assigned', 'approved'])) {
            return back()->with('error', 'Status permohonan tidak valid untuk dimulai.');
        }

        $serviceRequest->markAsInProgress();

        return back()->with('success', 'Status permohonan diubah menjadi "Sedang Dikerjakan".');
    }

    /**
     * Lab: Update status to testing
     */
    public function startTesting(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'in_progress') {
            return back()->with('error', 'Hanya permohonan dengan status "Sedang Dikerjakan" yang dapat dimulai analisis.');
        }

        $serviceRequest->markAsTesting();

        return back()->with('success', 'Status permohonan diubah menjadi "Sedang Analisis".');
    }

    /**
     * Lab: Mark as completed
     */
    public function complete(ServiceRequest $serviceRequest)
    {
        if (!in_array($serviceRequest->status, ['testing', 'in_progress'])) {
            return back()->with('error', 'Status permohonan tidak valid untuk diselesaikan.');
        }

        $serviceRequest->markAsCompleted();

        return back()->with('success', 'Permohonan berhasil diselesaikan.');
    }

    /**
     * Admin: Reject request
     */
    public function reject(Request $request, ServiceRequest $serviceRequest)
    {
        if (in_array($serviceRequest->status, ['completed', 'rejected', 'cancelled'])) {
            return back()->with('error', 'Permohonan dengan status ini tidak dapat ditolak.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $serviceRequest->markAsRejected($validated['rejection_reason']);

        return back()->with('success', 'Permohonan berhasil ditolak.');
    }

    /**
     * Staff: Add internal note
     */
    public function addNote(Request $request, ServiceRequest $serviceRequest)
    {
        // Check if user has permission (staff only)
        if (!Auth::user()->hasRole(['Super Admin', 'Direktur', 'Wakil Direktur', 'Kepala Lab', 'Anggota Lab', 'Sub Bagian TU & Keuangan'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambahkan catatan internal.');
        }

        $validated = $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        $serviceRequest->addInternalNote($validated['note'], Auth::id());

        return back()->with('success', 'Catatan internal berhasil ditambahkan.');
    }
}
