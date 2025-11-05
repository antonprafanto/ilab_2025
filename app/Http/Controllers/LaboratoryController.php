<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Laboratory::with('headUser');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $laboratories = $query->latest()->paginate(12);

        return view('laboratories.index', compact('laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Kepala Lab')->get();
        return view('laboratories.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:laboratories,code',
            'type' => 'required|in:chemistry,biology,physics,geology,engineering,computer,other',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'area_sqm' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'head_user_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours_start' => 'nullable|date_format:H:i',
            'operating_hours_end' => 'nullable|date_format:H:i',
            'operating_days' => 'nullable|array',
            'status' => 'required|in:active,maintenance,closed',
            'status_notes' => 'nullable|string',
            'facilities' => 'nullable|array',
            'certifications' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('laboratories', 'public');
        }

        $laboratory = Laboratory::create($validated);

        return redirect()->route('laboratories.show', $laboratory)
            ->with('success', 'Laboratorium berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratory $laboratory)
    {
        $laboratory->load(['headUser', 'rooms', 'equipment']);
        return view('laboratories.show', compact('laboratory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratory $laboratory)
    {
        $users = User::role('Kepala Lab')->get();
        return view('laboratories.edit', compact('laboratory', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:laboratories,code,' . $laboratory->id,
            'type' => 'required|in:chemistry,biology,physics,geology,engineering,computer,other',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'area_sqm' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'head_user_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours_start' => 'nullable|date_format:H:i',
            'operating_hours_end' => 'nullable|date_format:H:i',
            'operating_days' => 'nullable|array',
            'status' => 'required|in:active,maintenance,closed',
            'status_notes' => 'nullable|string',
            'facilities' => 'nullable|array',
            'certifications' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($laboratory->photo) {
                Storage::disk('public')->delete($laboratory->photo);
            }
            $validated['photo'] = $request->file('photo')->store('laboratories', 'public');
        }

        $laboratory->update($validated);

        return redirect()->route('laboratories.show', $laboratory)
            ->with('success', 'Laboratorium berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratory $laboratory)
    {
        // Delete photo
        if ($laboratory->photo) {
            Storage::disk('public')->delete($laboratory->photo);
        }

        $laboratory->delete();

        return redirect()->route('laboratories.index')
            ->with('success', 'Laboratorium berhasil dihapus!');
    }
}
