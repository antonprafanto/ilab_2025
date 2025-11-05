<?php

namespace App\Http\Controllers;

use App\Models\Reagent;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReagentController extends Controller
{
    public function index(Request $request)
    {
        $query = Reagent::with(['laboratory']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('cas_number', 'like', "%{$search}%")
                  ->orWhere('formula', 'like', "%{$search}%");
            });
        }

        if ($request->filled('laboratory_id')) {
            $query->where('laboratory_id', $request->laboratory_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('hazard_class')) {
            $query->where('hazard_class', $request->hazard_class);
        }

        $reagents = $query->latest()->paginate(15);
        $laboratories = Laboratory::active()->get();

        return view('reagents.index', compact('reagents', 'laboratories'));
    }

    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $reagent = null;

        return view('reagents.create', compact('laboratories', 'reagent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:reagents',
            'name' => 'required|string|max:255',
            'cas_number' => 'nullable|string|max:255',
            'formula' => 'nullable|string|max:255',
            'category' => 'required|in:acid,base,salt,organic,inorganic,solvent,indicator,standard,other',
            'grade' => 'nullable|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'hazard_class' => 'required|in:non_hazardous,flammable,corrosive,toxic,oxidizing,explosive,radioactive',
            'storage_location' => 'nullable|string|max:255',
            'storage_condition' => 'required|in:room_temperature,refrigerated,frozen,special',
            'status' => 'required|in:available,in_use,low_stock,expired,disposed',
            'min_stock_level' => 'nullable|numeric|min:0',
            'manufacturer' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'lot_number' => 'nullable|string|max:100',
            'catalog_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'opened_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'disposal_instructions' => 'nullable|string',
            'safety_notes' => 'nullable|string',
            'sds_file' => 'nullable|file|mimes:pdf|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('sds_file')) {
            $validated['sds_file'] = $request->file('sds_file')->store('reagents/sds', 'public');
        }

        $reagent = Reagent::create($validated);

        return redirect()->route('reagents.show', $reagent)
            ->with('success', 'Reagen berhasil ditambahkan!');
    }

    public function show(Reagent $reagent)
    {
        $reagent->load(['laboratory']);
        return view('reagents.show', compact('reagent'));
    }

    public function edit(Reagent $reagent)
    {
        $laboratories = Laboratory::active()->get();

        return view('reagents.edit', compact('reagent', 'laboratories'));
    }

    public function update(Request $request, Reagent $reagent)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:reagents,code,' . $reagent->id,
            'name' => 'required|string|max:255',
            'cas_number' => 'nullable|string|max:255',
            'formula' => 'nullable|string|max:255',
            'category' => 'required|in:acid,base,salt,organic,inorganic,solvent,indicator,standard,other',
            'grade' => 'nullable|string|max:100',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'hazard_class' => 'required|in:non_hazardous,flammable,corrosive,toxic,oxidizing,explosive,radioactive',
            'storage_location' => 'nullable|string|max:255',
            'storage_condition' => 'required|in:room_temperature,refrigerated,frozen,special',
            'status' => 'required|in:available,in_use,low_stock,expired,disposed',
            'min_stock_level' => 'nullable|numeric|min:0',
            'manufacturer' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'lot_number' => 'nullable|string|max:100',
            'catalog_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'opened_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'disposal_instructions' => 'nullable|string',
            'safety_notes' => 'nullable|string',
            'sds_file' => 'nullable|file|mimes:pdf|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('sds_file')) {
            if ($reagent->sds_file) {
                Storage::disk('public')->delete($reagent->sds_file);
            }
            $validated['sds_file'] = $request->file('sds_file')->store('reagents/sds', 'public');
        }

        $reagent->update($validated);

        return redirect()->route('reagents.show', $reagent)
            ->with('success', 'Reagen berhasil diperbarui!');
    }

    public function destroy(Reagent $reagent)
    {
        if ($reagent->sds_file) {
            Storage::disk('public')->delete($reagent->sds_file);
        }

        $reagent->delete();

        return redirect()->route('reagents.index')
            ->with('success', 'Reagen berhasil dihapus!');
    }
}
