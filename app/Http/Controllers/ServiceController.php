<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource (Service Catalog)
     */
    public function index(Request $request)
    {
        $query = Service::with('laboratory')->active();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Filter by laboratory
        if ($request->filled('laboratory_id')) {
            $query->laboratory($request->laboratory_id);
        }

        // Filter by price range
        if ($request->filled('min_price') && $request->filled('max_price')) {
            // Validate min <= max
            if ($request->min_price > $request->max_price) {
                return redirect()->route('services.index')
                    ->withInput()
                    ->withErrors(['price' => 'Harga minimum tidak boleh lebih besar dari harga maksimum.']);
            }
        }

        if ($request->filled('min_price')) {
            $query->where('price_external', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_external', '<=', $request->max_price);
        }

        // Filter by duration
        if ($request->filled('duration')) {
            if ($request->duration == 'short') {
                $query->where('duration_days', '<', 3);
            } elseif ($request->duration == 'medium') {
                $query->whereBetween('duration_days', [3, 7]);
            } elseif ($request->duration == 'long') {
                $query->where('duration_days', '>', 7);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        if ($sortBy == 'popularity') {
            $query->popular();
        } elseif ($sortBy == 'price') {
            $query->orderBy('price_external', $sortOrder);
        } elseif ($sortBy == 'name') {
            $query->orderBy('name', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $services = $query->paginate(12);

        // Get filter options
        $laboratories = Laboratory::active()->orderBy('name')->get();
        $categories = [
            'kimia' => 'Kimia',
            'biologi' => 'Biologi',
            'fisika' => 'Fisika',
            'mikrobiologi' => 'Mikrobiologi',
            'material' => 'Material',
            'lingkungan' => 'Lingkungan',
            'pangan' => 'Pangan',
            'farmasi' => 'Farmasi',
        ];

        return view('services.index', compact('services', 'laboratories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratories = Laboratory::active()->orderBy('name')->get();

        // Check if laboratories exist
        if ($laboratories->isEmpty()) {
            return redirect()->route('laboratories.index')
                ->with('error', 'Tidak ada laboratorium aktif. Silakan buat laboratorium terlebih dahulu.');
        }

        return view('services.create', compact('laboratories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert JSON strings to arrays (from form JavaScript)
        if ($request->filled('requirements') && is_string($request->requirements)) {
            $request->merge(['requirements' => json_decode($request->requirements, true)]);
        }
        if ($request->filled('equipment_needed') && is_string($request->equipment_needed)) {
            $request->merge(['equipment_needed' => json_decode($request->equipment_needed, true)]);
        }
        if ($request->filled('deliverables') && is_string($request->deliverables)) {
            $request->merge(['deliverables' => json_decode($request->deliverables, true)]);
        }

        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:services,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:kimia,biologi,fisika,mikrobiologi,material,lingkungan,pangan,farmasi',
            'subcategory' => 'nullable|string|max:100',
            'method' => 'nullable|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price_internal' => 'required|numeric|min:0',
            'price_external_edu' => 'required|numeric|min:0',
            'price_external' => 'required|numeric|min:0',
            'urgent_surcharge_percent' => 'nullable|integer|min:0|max:100',
            'requirements' => 'nullable|array',
            'equipment_needed' => ['nullable', 'array', function ($attribute, $value, $fail) {
                if (is_array($value) && !empty($value)) {
                    $existingIds = \App\Models\Equipment::whereIn('id', $value)->pluck('id')->toArray();
                    $invalidIds = array_diff($value, $existingIds);
                    if (!empty($invalidIds)) {
                        $fail('Equipment ID tidak valid: ' . implode(', ', $invalidIds));
                    }
                }
            }],
            'sample_preparation' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'min_sample' => 'nullable|integer|min:1',
            'max_sample' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Convert empty arrays to null
        if (empty($validated['requirements'])) {
            $validated['requirements'] = null;
        }
        if (empty($validated['equipment_needed'])) {
            $validated['equipment_needed'] = null;
        }
        if (empty($validated['deliverables'])) {
            $validated['deliverables'] = null;
        }

        $service = Service::create($validated);

        return redirect()->route('services.show', $service)
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource (increment popularity).
     */
    public function show(Service $service)
    {
        $service->load('laboratory');

        // Increment popularity counter
        $service->incrementPopularity();

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $laboratories = Laboratory::active()->orderBy('name')->get();

        // Check if laboratories exist
        if ($laboratories->isEmpty()) {
            return redirect()->route('laboratories.index')
                ->with('error', 'Tidak ada laboratorium aktif. Silakan buat laboratorium terlebih dahulu.');
        }

        return view('services.edit', compact('service', 'laboratories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Convert JSON strings to arrays (from form JavaScript)
        if ($request->filled('requirements') && is_string($request->requirements)) {
            $request->merge(['requirements' => json_decode($request->requirements, true)]);
        }
        if ($request->filled('equipment_needed') && is_string($request->equipment_needed)) {
            $request->merge(['equipment_needed' => json_decode($request->equipment_needed, true)]);
        }
        if ($request->filled('deliverables') && is_string($request->deliverables)) {
            $request->merge(['deliverables' => json_decode($request->deliverables, true)]);
        }

        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:services,code,' . $service->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:kimia,biologi,fisika,mikrobiologi,material,lingkungan,pangan,farmasi',
            'subcategory' => 'nullable|string|max:100',
            'method' => 'nullable|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price_internal' => 'required|numeric|min:0',
            'price_external_edu' => 'required|numeric|min:0',
            'price_external' => 'required|numeric|min:0',
            'urgent_surcharge_percent' => 'nullable|integer|min:0|max:100',
            'requirements' => 'nullable|array',
            'equipment_needed' => ['nullable', 'array', function ($attribute, $value, $fail) {
                if (is_array($value) && !empty($value)) {
                    $existingIds = \App\Models\Equipment::whereIn('id', $value)->pluck('id')->toArray();
                    $invalidIds = array_diff($value, $existingIds);
                    if (!empty($invalidIds)) {
                        $fail('Equipment ID tidak valid: ' . implode(', ', $invalidIds));
                    }
                }
            }],
            'sample_preparation' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'min_sample' => 'nullable|integer|min:1',
            'max_sample' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Convert empty arrays to null
        if (empty($validated['requirements'])) {
            $validated['requirements'] = null;
        }
        if (empty($validated['equipment_needed'])) {
            $validated['equipment_needed'] = null;
        }
        if (empty($validated['deliverables'])) {
            $validated['deliverables'] = null;
        }

        $service->update($validated);

        return redirect()->route('services.show', $service)
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
