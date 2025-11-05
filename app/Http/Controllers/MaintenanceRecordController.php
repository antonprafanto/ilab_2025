<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRecord::with(['equipment', 'technician', 'verifier']);

        // Filter by equipment
        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->equipment_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('maintenance_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('equipment', function($eq) use ($search) {
                      $eq->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $maintenances = $query->latest('scheduled_date')->paginate(15);
        $equipments = Equipment::all();

        return view('maintenance.index', compact('maintenances', 'equipments'));
    }

    public function create(Request $request)
    {
        $equipments = Equipment::all();
        $users = User::all();
        $maintenance = null;

        // Pre-select equipment if provided
        $selectedEquipment = $request->filled('equipment_id')
            ? Equipment::find($request->equipment_id)
            : null;

        return view('maintenance.create', compact('equipments', 'users', 'maintenance', 'selectedEquipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'maintenance_code' => 'required|string|max:50|unique:maintenance_records,maintenance_code',
            'type' => 'required|in:preventive,corrective,breakdown,inspection,cleaning,calibration,replacement',
            'priority' => 'required|in:low,medium,high,urgent',
            'scheduled_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled,postponed',
            'description' => 'nullable|string',
            'work_performed' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'performed_by' => 'nullable|exists:users,id',
            'verified_by' => 'nullable|exists:users,id',
            'labor_cost' => 'nullable|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'completed_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Calculate total cost
        if (isset($validated['labor_cost']) || isset($validated['parts_cost'])) {
            $validated['total_cost'] = ($validated['labor_cost'] ?? 0) + ($validated['parts_cost'] ?? 0);
        }

        $maintenance = MaintenanceRecord::create($validated);

        // Update equipment maintenance dates if completed
        if ($maintenance->status === 'completed' && $maintenance->completed_date) {
            $equipment = $maintenance->equipment;
            $equipment->last_maintenance = $maintenance->completed_date;
            if ($maintenance->next_maintenance_date) {
                $equipment->next_maintenance = $maintenance->next_maintenance_date;
            }
            $equipment->save();
        }

        return redirect()->route('maintenance.show', $maintenance)
            ->with('success', 'Record maintenance berhasil ditambahkan!');
    }

    public function show(MaintenanceRecord $maintenance)
    {
        $maintenance->load(['equipment', 'technician', 'verifier']);
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRecord $maintenance)
    {
        $equipments = Equipment::all();
        $users = User::all();
        return view('maintenance.edit', compact('maintenance', 'equipments', 'users'));
    }

    public function update(Request $request, MaintenanceRecord $maintenance)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'maintenance_code' => 'required|string|max:50|unique:maintenance_records,maintenance_code,' . $maintenance->id,
            'type' => 'required|in:preventive,corrective,breakdown,inspection,cleaning,calibration,replacement',
            'priority' => 'required|in:low,medium,high,urgent',
            'scheduled_date' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled,postponed',
            'description' => 'nullable|string',
            'work_performed' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'performed_by' => 'nullable|exists:users,id',
            'verified_by' => 'nullable|exists:users,id',
            'labor_cost' => 'nullable|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'completed_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Calculate total cost
        if (isset($validated['labor_cost']) || isset($validated['parts_cost'])) {
            $validated['total_cost'] = ($validated['labor_cost'] ?? 0) + ($validated['parts_cost'] ?? 0);
        }

        $maintenance->update($validated);

        // Update equipment maintenance dates if completed
        if ($maintenance->status === 'completed' && $maintenance->completed_date) {
            $equipment = $maintenance->equipment;
            $equipment->last_maintenance = $maintenance->completed_date;
            if ($maintenance->next_maintenance_date) {
                $equipment->next_maintenance = $maintenance->next_maintenance_date;
            }
            $equipment->save();
        }

        return redirect()->route('maintenance.show', $maintenance)
            ->with('success', 'Record maintenance berhasil diperbarui!');
    }

    public function destroy(MaintenanceRecord $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Record maintenance berhasil dihapus!');
    }
}
