<?php

namespace App\Http\Controllers;

use App\Models\CalibrationRecord;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

class CalibrationRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = CalibrationRecord::with(['equipment', 'calibrator', 'verifier']);

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

        // Filter by result
        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('calibration_code', 'like', "%{$search}%")
                  ->orWhere('certificate_number', 'like', "%{$search}%")
                  ->orWhere('external_lab', 'like', "%{$search}%")
                  ->orWhereHas('equipment', function($eq) use ($search) {
                      $eq->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $calibrations = $query->latest('calibration_date')->paginate(15);
        $equipments = Equipment::all();

        return view('calibration.index', compact('calibrations', 'equipments'));
    }

    public function create(Request $request)
    {
        $equipments = Equipment::all();
        $users = User::all();
        $calibration = null;

        // Pre-select equipment if provided
        $selectedEquipment = $request->filled('equipment_id')
            ? Equipment::find($request->equipment_id)
            : null;

        return view('calibration.create', compact('equipments', 'users', 'calibration', 'selectedEquipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'calibration_code' => 'required|string|max:50|unique:calibration_records,calibration_code',
            'type' => 'required|in:internal,external,verification,adjustment',
            'method' => 'nullable|in:comparison,direct,simulation,functional',
            'calibration_date' => 'required|date',
            'interval_months' => 'nullable|integer|min:1|max:60',
            'status' => 'required|in:scheduled,in_progress,passed,failed,conditional,cancelled',
            'result' => 'nullable|in:pass,fail,conditional',
            'measurement_results' => 'nullable|string',
            'adjustments_made' => 'nullable|string',
            'accuracy' => 'nullable|string|max:255',
            'uncertainty' => 'nullable|string|max:255',
            'range_calibrated' => 'nullable|string|max:255',
            'standards_used' => 'nullable|string',
            'equipment_used' => 'nullable|string',
            'reference_conditions' => 'nullable|string',
            'calibrated_by' => 'nullable|exists:users,id',
            'verified_by' => 'nullable|exists:users,id',
            'external_lab' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'certificate_issue_date' => 'nullable|date',
            'certificate_expiry_date' => 'nullable|date',
            'certificate_file' => 'nullable|file|mimes:pdf|max:10240',
            'calibration_cost' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'next_calibration_date' => 'nullable|date',
            'recommendations' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Handle certificate file upload
        if ($request->hasFile('certificate_file')) {
            $validated['certificate_file'] = $request->file('certificate_file')->store('calibrations/certificates', 'public');
        }

        $calibration = CalibrationRecord::create($validated);

        // Update equipment calibration dates if passed
        if (in_array($calibration->status, ['passed']) || $calibration->result === 'pass') {
            $equipment = $calibration->equipment;
            $equipment->last_calibration = $calibration->calibration_date;
            if ($calibration->next_calibration_date) {
                $equipment->next_calibration = $calibration->next_calibration_date;
            }
            $equipment->save();
        }

        return redirect()->route('calibration.show', $calibration)
            ->with('success', 'Record kalibrasi berhasil ditambahkan!');
    }

    public function show(CalibrationRecord $calibration)
    {
        $calibration->load(['equipment', 'calibrator', 'verifier']);
        return view('calibration.show', compact('calibration'));
    }

    public function edit(CalibrationRecord $calibration)
    {
        $equipments = Equipment::all();
        $users = User::all();
        return view('calibration.edit', compact('calibration', 'equipments', 'users'));
    }

    public function update(Request $request, CalibrationRecord $calibration)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'calibration_code' => 'required|string|max:50|unique:calibration_records,calibration_code,' . $calibration->id,
            'type' => 'required|in:internal,external,verification,adjustment',
            'method' => 'nullable|in:comparison,direct,simulation,functional',
            'calibration_date' => 'required|date',
            'interval_months' => 'nullable|integer|min:1|max:60',
            'status' => 'required|in:scheduled,in_progress,passed,failed,conditional,cancelled',
            'result' => 'nullable|in:pass,fail,conditional',
            'measurement_results' => 'nullable|string',
            'adjustments_made' => 'nullable|string',
            'accuracy' => 'nullable|string|max:255',
            'uncertainty' => 'nullable|string|max:255',
            'range_calibrated' => 'nullable|string|max:255',
            'standards_used' => 'nullable|string',
            'equipment_used' => 'nullable|string',
            'reference_conditions' => 'nullable|string',
            'calibrated_by' => 'nullable|exists:users,id',
            'verified_by' => 'nullable|exists:users,id',
            'external_lab' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'certificate_issue_date' => 'nullable|date',
            'certificate_expiry_date' => 'nullable|date',
            'certificate_file' => 'nullable|file|mimes:pdf|max:10240',
            'calibration_cost' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'next_calibration_date' => 'nullable|date',
            'recommendations' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Handle certificate file upload
        if ($request->hasFile('certificate_file')) {
            // Delete old file if exists
            if ($calibration->certificate_file && \Storage::disk('public')->exists($calibration->certificate_file)) {
                \Storage::disk('public')->delete($calibration->certificate_file);
            }
            $validated['certificate_file'] = $request->file('certificate_file')->store('calibrations/certificates', 'public');
        }

        $calibration->update($validated);

        // Update equipment calibration dates if passed
        if (in_array($calibration->status, ['passed']) || $calibration->result === 'pass') {
            $equipment = $calibration->equipment;
            $equipment->last_calibration = $calibration->calibration_date;
            if ($calibration->next_calibration_date) {
                $equipment->next_calibration = $calibration->next_calibration_date;
            }
            $equipment->save();
        }

        return redirect()->route('calibration.show', $calibration)
            ->with('success', 'Record kalibrasi berhasil diperbarui!');
    }

    public function destroy(CalibrationRecord $calibration)
    {
        // Delete certificate file if exists
        if ($calibration->certificate_file && \Storage::disk('public')->exists($calibration->certificate_file)) {
            \Storage::disk('public')->delete($calibration->certificate_file);
        }

        $calibration->delete();

        return redirect()->route('calibration.index')
            ->with('success', 'Record kalibrasi berhasil dihapus!');
    }
}
