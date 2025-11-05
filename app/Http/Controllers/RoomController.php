<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['laboratory', 'responsiblePerson']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('building', 'like', "%{$search}%");
            });
        }

        // Filter by laboratory
        if ($request->filled('laboratory_id')) {
            $query->where('laboratory_id', $request->laboratory_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->latest()->paginate(15);
        $laboratories = Laboratory::active()->get();

        return view('rooms.index', compact('rooms', 'laboratories'));
    }

    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $users = User::role(['Kepala Lab', 'Anggota Lab', 'Laboran'])->get();

        return view('rooms.create', compact('laboratories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:rooms',
            'name' => 'required|string|max:255',
            'type' => 'required|in:research,teaching,storage,preparation,meeting,office',
            'area' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'floor' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'responsible_person' => 'nullable|exists:users,id',
            'safety_equipment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $room = Room::create($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Ruang berhasil ditambahkan!');
    }

    public function show(Room $room)
    {
        $room->load(['laboratory', 'responsiblePerson']);
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $laboratories = Laboratory::active()->get();
        $users = User::role(['Kepala Lab', 'Anggota Lab', 'Laboran'])->get();

        return view('rooms.edit', compact('room', 'laboratories', 'users'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:50|unique:rooms,code,' . $room->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:research,teaching,storage,preparation,meeting,office',
            'area' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'floor' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'responsible_person' => 'nullable|exists:users,id',
            'safety_equipment' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Ruang berhasil diperbarui!');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Ruang berhasil dihapus!');
    }
}
