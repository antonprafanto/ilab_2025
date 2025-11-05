<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipment::with(['laboratory', 'assignedUser']);

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

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $equipment = $query->latest()->paginate(12);
        $laboratories = Laboratory::active()->get();

        return view('equipment.index', compact('equipment', 'laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all(); // For assigned_to
        return view('equipment.create', compact('laboratories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code',
            'laboratory_id' => 'required|exists:laboratories,id',
            'category' => 'required|in:analytical,measurement,preparation,safety,computer,general',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:equipment,serial_number',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'warranty_until' => 'nullable|date',
            'condition' => 'required|in:excellent,good,fair,poor,broken',
            'status' => 'required|in:available,in_use,maintenance,calibration,broken,retired',
            'status_notes' => 'nullable|string',
            'location_detail' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'calibration_interval_days' => 'nullable|integer|min:1',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('equipment', 'public');
        }

        $equipment = Equipment::create($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        // Load only relationships that exist (maintenance & calibration will be added in Chapter 7B)
        $equipment->load(['laboratory', 'assignedUser']);
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();
        return view('equipment.edit', compact('equipment', 'laboratories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code,' . $equipment->id,
            'laboratory_id' => 'required|exists:laboratories,id',
            'category' => 'required|in:analytical,measurement,preparation,safety,computer,general',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:equipment,serial_number,' . $equipment->id,
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'warranty_until' => 'nullable|date',
            'condition' => 'required|in:excellent,good,fair,poor,broken',
            'status' => 'required|in:available,in_use,maintenance,calibration,broken,retired',
            'status_notes' => 'nullable|string',
            'location_detail' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'calibration_interval_days' => 'nullable|integer|min:1',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($equipment->photo) {
                Storage::disk('public')->delete($equipment->photo);
            }
            $validated['photo'] = $request->file('photo')->store('equipment', 'public');
        }

        $equipment->update($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        // Delete photo
        if ($equipment->photo) {
            Storage::disk('public')->delete($equipment->photo);
        }

        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment berhasil dihapus!');
    }
}
