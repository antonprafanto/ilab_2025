<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SampleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sample::with(['laboratory', 'submitter', 'analyzer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        if ($request->filled('laboratory_id')) {
            $query->where('laboratory_id', $request->laboratory_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $samples = $query->latest('received_date')->paginate(15);
        $laboratories = Laboratory::active()->get();

        return view('samples.index', compact('samples', 'laboratories'));
    }

    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();
        $sample = null;

        return view('samples.create', compact('laboratories', 'users', 'sample'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:samples',
            'name' => 'required|string|max:255',
            'type' => 'required|in:biological,chemical,environmental,food,pharmaceutical,other',
            'source' => 'nullable|string|max:255',
            'storage_location' => 'nullable|string|max:255',
            'storage_condition' => 'required|in:room_temperature,refrigerated,frozen,special',
            'status' => 'required|in:received,in_analysis,completed,archived,disposed',
            'received_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:received_date',
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'submitted_by' => 'required|exists:users,id',
            'analyzed_by' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'test_parameters' => 'nullable|string',
            'analysis_results' => 'nullable|string',
            'result_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analysis_date' => 'nullable|date',
            'result_date' => 'nullable|date',
            'priority' => 'required|in:low,normal,high,urgent',
            'special_requirements' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('result_file')) {
            $validated['result_file'] = $request->file('result_file')->store('samples/results', 'public');
        }

        $sample = Sample::create($validated);

        return redirect()->route('samples.show', $sample)
            ->with('success', 'Sampel berhasil ditambahkan!');
    }

    public function show(Sample $sample)
    {
        $sample->load(['laboratory', 'submitter', 'analyzer']);
        return view('samples.show', compact('sample'));
    }

    public function edit(Sample $sample)
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();

        return view('samples.edit', compact('sample', 'laboratories', 'users'));
    }

    public function update(Request $request, Sample $sample)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:samples,code,' . $sample->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:biological,chemical,environmental,food,pharmaceutical,other',
            'source' => 'nullable|string|max:255',
            'storage_location' => 'nullable|string|max:255',
            'storage_condition' => 'required|in:room_temperature,refrigerated,frozen,special',
            'status' => 'required|in:received,in_analysis,completed,archived,disposed',
            'received_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:received_date',
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'submitted_by' => 'required|exists:users,id',
            'analyzed_by' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'test_parameters' => 'nullable|string',
            'analysis_results' => 'nullable|string',
            'result_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analysis_date' => 'nullable|date',
            'result_date' => 'nullable|date',
            'priority' => 'required|in:low,normal,high,urgent',
            'special_requirements' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('result_file')) {
            if ($sample->result_file) {
                Storage::disk('public')->delete($sample->result_file);
            }
            $validated['result_file'] = $request->file('result_file')->store('samples/results', 'public');
        }

        $sample->update($validated);

        return redirect()->route('samples.show', $sample)
            ->with('success', 'Sampel berhasil diperbarui!');
    }

    public function destroy(Sample $sample)
    {
        if ($sample->result_file) {
            Storage::disk('public')->delete($sample->result_file);
        }

        $sample->delete();

        return redirect()->route('samples.index')
            ->with('success', 'Sampel berhasil dihapus!');
    }
}
