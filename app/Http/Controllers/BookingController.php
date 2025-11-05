<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Laboratory;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings (admin view)
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'laboratory', 'equipment']);

        // Filters
        if ($request->filled('laboratory_id')) {
            $query->byLab($request->laboratory_id);
        }

        if ($request->filled('equipment_id')) {
            $query->byEquipment($request->equipment_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('booking_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('booking_number', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);

        $laboratories = Laboratory::all();
        $equipment = Equipment::all();

        return view('bookings.index', compact('bookings', 'laboratories', 'equipment'));
    }

    /**
     * Display user's own bookings
     */
    public function myBookings(Request $request)
    {
        $query = Booking::with(['laboratory', 'equipment'])
            ->byUser(Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('bookings.my-bookings', compact('bookings'));
    }

    /**
     * Display approval queue for Kepala Lab
     */
    public function approvalQueue(Request $request)
    {
        $user = Auth::user();

        // Get labs where user is Kepala Lab
        $labIds = Laboratory::where('head_user_id', $user->id)->pluck('id');

        $query = Booking::with(['user', 'laboratory', 'equipment'])
            ->whereIn('laboratory_id', $labIds)
            ->pending();

        $bookings = $query->orderBy('booking_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);

        $pendingCount = $bookings->total();

        return view('bookings.approval-queue', compact('bookings', 'pendingCount'));
    }

    /**
     * Show calendar view
     */
    public function calendar(Request $request)
    {
        $laboratories = Laboratory::all();
        $equipment = Equipment::all();

        return view('bookings.calendar', compact('laboratories', 'equipment'));
    }

    /**
     * API endpoint for calendar events (JSON)
     */
    public function events(Request $request)
    {
        $query = Booking::with(['user', 'laboratory', 'equipment']);

        // Filter by date range (from FullCalendar)
        if ($request->filled('start')) {
            $query->where('booking_date', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->where('booking_date', '<=', $request->end);
        }

        // Filter by laboratory
        if ($request->filled('laboratory_id')) {
            $query->byLab($request->laboratory_id);
        }

        // Filter by equipment
        if ($request->filled('equipment_id')) {
            $query->byEquipment($request->equipment_id);
        }

        $bookings = $query->get();

        // Format for FullCalendar
        $events = $bookings->map(function ($booking) {
            $start = $booking->booking_date->format('Y-m-d') . 'T' . Carbon::parse($booking->start_time)->format('H:i:s');
            $end = $booking->booking_date->format('Y-m-d') . 'T' . Carbon::parse($booking->end_time)->format('H:i:s');

            // Color based on status
            $color = match($booking->status) {
                'pending' => '#f59e0b',      // Orange
                'approved' => '#3b82f6',     // Blue
                'confirmed' => '#8b5cf6',    // Purple
                'checked_in' => '#10b981',   // Green
                'completed' => '#6b7280',    // Gray
                'cancelled' => '#ef4444',    // Red
                'no_show' => '#ef4444',      // Red
                default => '#6b7280',        // Gray
            };

            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $start,
                'end' => $end,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'booking_number' => $booking->booking_number,
                    'status' => $booking->status,
                    'status_label' => $booking->status_label,
                    'laboratory' => $booking->laboratory->name,
                    'equipment' => $booking->equipment?->name,
                    'user' => $booking->user->name,
                    'url' => route('bookings.show', $booking),
                ],
            ];
        });

        return response()->json($events);
    }

    /**
     * Show the form for creating a new booking
     */
    public function create(Request $request)
    {
        $laboratories = Laboratory::all();
        $equipment = Equipment::all();

        // Pre-fill from query params (from calendar click)
        $prefilledDate = $request->query('date');
        $prefilledTime = $request->query('time');
        $prefilledLab = $request->query('laboratory_id');

        return view('bookings.create', compact('laboratories', 'equipment', 'prefilledDate', 'prefilledTime', 'prefilledLab'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'equipment_id' => 'nullable|exists:equipment,id',
            'booking_type' => 'required|in:research,testing,training,maintenance,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purpose' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'expected_participants' => 'nullable|integer|min:1',
            'special_requirements' => 'nullable|string',
            'is_recurring' => 'nullable|boolean',
            'recurrence_pattern' => 'nullable|required_if:is_recurring,1|in:daily,weekly,monthly',
            'recurrence_end_date' => 'nullable|required_if:is_recurring,1|date|after:booking_date',
        ]);

        $validated['user_id'] = Auth::id();

        // Create booking
        $booking = Booking::create($validated);

        // Check for conflicts
        $conflicts = $booking->detectConflicts();

        if (!empty($conflicts)) {
            $booking->delete(); // Rollback
            return back()->withInput()->with('error', 'Konflik jadwal ditemukan. Silakan pilih waktu lain.');
        }

        // Generate recurring bookings if needed
        if ($booking->is_recurring) {
            $booking->generateRecurringBookings();
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking berhasil dibuat dengan nomor: ' . $booking->booking_number);
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'laboratory', 'equipment', 'serviceRequest', 'approvedBy', 'childBookings']);

        // Check conflicts
        $conflicts = $booking->detectConflicts();

        return view('bookings.show', compact('booking', 'conflicts'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        // Only owner or admin can edit
        if ($booking->user_id !== Auth::id() && !Auth::user()->hasRole(['Super Admin', 'Kepala Lab'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit booking ini.');
        }

        // Cannot edit if already checked in or completed
        if (in_array($booking->status, ['checked_in', 'completed', 'cancelled', 'no_show'])) {
            return back()->with('error', 'Booking dengan status ini tidak dapat diedit.');
        }

        $laboratories = Laboratory::all();
        $equipment = Equipment::all();

        return view('bookings.edit', compact('booking', 'laboratories', 'equipment'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id() && !Auth::user()->hasRole(['Super Admin', 'Kepala Lab'])) {
            abort(403);
        }

        $validated = $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
            'equipment_id' => 'nullable|exists:equipment,id',
            'booking_type' => 'required|in:research,testing,training,maintenance,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'purpose' => 'required|string',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'expected_participants' => 'nullable|integer|min:1',
            'special_requirements' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Re-check conflicts
        $conflicts = $booking->detectConflicts();

        if (!empty($conflicts)) {
            return back()->with('warning', 'Update berhasil, namun ada konflik jadwal yang terdeteksi.');
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Remove the specified booking
     */
    public function destroy(Booking $booking)
    {
        // Only owner or admin can delete
        if ($booking->user_id !== Auth::id() && !Auth::user()->hasRole(['Super Admin'])) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('bookings.my-bookings')
            ->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * Approve booking (Kepala Lab)
     */
    public function approve(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking dengan status "Menunggu Persetujuan" yang dapat disetujui.');
        }

        $validated = $request->validate([
            'approval_notes' => 'nullable|string|max:500',
        ]);

        try {
            $booking->approve(Auth::id(), $validated['approval_notes'] ?? null);
            return back()->with('success', 'Booking berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui booking: ' . $e->getMessage());
        }
    }

    /**
     * User confirms approved booking
     */
    public function confirm(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Hanya pemilik booking yang dapat mengonfirmasi.');
        }

        try {
            $booking->confirm();
            return back()->with('success', 'Booking berhasil dikonfirmasi. Silakan check-in pada waktu yang telah ditentukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengonfirmasi booking: ' . $e->getMessage());
        }
    }

    /**
     * Cancel booking
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Only owner or admin can cancel
        if ($booking->user_id !== Auth::id() && !Auth::user()->hasRole(['Super Admin', 'Kepala Lab'])) {
            abort(403);
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        try {
            $booking->cancel(Auth::id(), $validated['cancellation_reason']);
            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    /**
     * Check-in kiosk view
     */
    public function kiosk()
    {
        // Get today's bookings that can be checked in
        $bookings = Booking::with(['user', 'laboratory', 'equipment'])
            ->today()
            ->whereIn('status', ['confirmed', 'approved', 'checked_in'])
            ->orderBy('start_time')
            ->get();

        return view('bookings.kiosk', compact('bookings'));
    }

    /**
     * Process check-in
     */
    public function checkIn(Request $request, Booking $booking)
    {
        if (!$booking->canCheckIn()) {
            return back()->with('error', 'Booking ini tidak dapat di-check-in saat ini. Pastikan status dan waktu sudah sesuai.');
        }

        try {
            $booking->checkIn(Auth::id());
            return back()->with('success', 'Check-in berhasil! Selamat menggunakan laboratorium.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal check-in: ' . $e->getMessage());
        }
    }

    /**
     * Process check-out
     */
    public function checkOut(Request $request, Booking $booking)
    {
        if (!$booking->canCheckOut()) {
            return back()->with('error', 'Booking ini tidak dapat di-check-out. Pastikan sudah check-in terlebih dahulu.');
        }

        try {
            $booking->checkOut(Auth::id());
            return back()->with('success', 'Check-out berhasil! Terima kasih telah menggunakan laboratorium.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal check-out: ' . $e->getMessage());
        }
    }

    /**
     * Mark booking as no-show
     */
    public function markNoShow(Booking $booking)
    {
        // Only staff can mark no-show
        if (!Auth::user()->hasRole(['Super Admin', 'Kepala Lab', 'Anggota Lab'])) {
            abort(403);
        }

        try {
            $booking->markAsNoShow(Auth::id());
            return back()->with('success', 'Booking ditandai sebagai tidak hadir.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menandai no-show: ' . $e->getMessage());
        }
    }
}
