<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sop::with(['laboratory', 'preparer', 'approver']);

        // Filter by laboratory
        if ($request->filled('laboratory_id')) {
            $query->where('laboratory_id', $request->laboratory_id);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sops = $query->latest()->paginate(12);
        $laboratories = Laboratory::active()->get();

        return view('sops.index', compact('sops', 'laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();
        return view('sops.create', compact('laboratories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:sops,code',
            'title' => 'required|string|max:255',
            'category' => 'required|in:equipment,testing,safety,quality,maintenance,calibration,general',
            'laboratory_id' => 'nullable|exists:laboratories,id',
            'version' => 'nullable|string|max:20',
            'purpose' => 'nullable|string',
            'scope' => 'nullable|string',
            'description' => 'nullable|string',
            'steps' => 'nullable|array',
            'requirements' => 'nullable|string',
            'safety_precautions' => 'nullable|string',
            'references' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'status' => 'required|in:draft,review,approved,archived',
            'prepared_by' => 'nullable|exists:users,id',
            'reviewed_by' => 'nullable|exists:users,id',
            'approved_by' => 'nullable|exists:users,id',
            'effective_date' => 'nullable|date',
            'review_interval_months' => 'nullable|integer|min:1|max:60',
            'revision_notes' => 'nullable|string',
        ]);

        // Handle document file upload
        if ($request->hasFile('document_file')) {
            $validated['document_file'] = $request->file('document_file')->store('sops/documents', 'public');
        }

        // Set prepared_by to current user if not specified
        if (!isset($validated['prepared_by'])) {
            $validated['prepared_by'] = auth()->id();
        }

        $sop = Sop::create($validated);

        return redirect()->route('sops.show', $sop)
            ->with('success', 'SOP berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sop $sop)
    {
        $sop->load(['laboratory', 'preparer', 'reviewer', 'approver']);
        return view('sops.show', compact('sop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sop $sop)
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();
        return view('sops.edit', compact('sop', 'laboratories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sop $sop)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:sops,code,' . $sop->id,
            'title' => 'required|string|max:255',
            'category' => 'required|in:equipment,testing,safety,quality,maintenance,calibration,general',
            'laboratory_id' => 'nullable|exists:laboratories,id',
            'version' => 'nullable|string|max:20',
            'purpose' => 'nullable|string',
            'scope' => 'nullable|string',
            'description' => 'nullable|string',
            'steps' => 'nullable|array',
            'requirements' => 'nullable|string',
            'safety_precautions' => 'nullable|string',
            'references' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|in:draft,review,approved,archived',
            'prepared_by' => 'nullable|exists:users,id',
            'reviewed_by' => 'nullable|exists:users,id',
            'approved_by' => 'nullable|exists:users,id',
            'effective_date' => 'nullable|date',
            'review_interval_months' => 'nullable|integer|min:1|max:60',
            'revision_notes' => 'nullable|string',
        ]);

        // Handle document file upload
        if ($request->hasFile('document_file')) {
            // Delete old document
            if ($sop->document_file) {
                Storage::disk('public')->delete($sop->document_file);
            }
            $validated['document_file'] = $request->file('document_file')->store('sops/documents', 'public');
        }

        $sop->update($validated);

        return redirect()->route('sops.show', $sop)
            ->with('success', 'SOP berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sop $sop)
    {
        // Delete document file
        if ($sop->document_file) {
            Storage::disk('public')->delete($sop->document_file);
        }

        $sop->delete();

        return redirect()->route('sops.index')
            ->with('success', 'SOP berhasil dihapus!');
    }
}
