<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_number',
        'user_id',
        'laboratory_id',
        'equipment_id',
        'service_request_id',
        'booking_type',
        'title',
        'description',
        'purpose',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_end_date',
        'parent_booking_id',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
        'checked_in_at',
        'checked_out_at',
        'checked_in_by',
        'checked_out_by',
        'cancelled_by',
        'cancelled_at',
        'cancellation_reason',
        'expected_participants',
        'special_requirements',
        'internal_notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'recurrence_end_date' => 'date',
        'is_recurring' => 'boolean',
        'approved_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'duration_hours' => 'decimal:2',
        'expected_participants' => 'integer',
    ];

    /**
     * Boot method - auto-generate booking number and calculate duration
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = static::generateBookingNumber();
            }

            // Calculate duration if not set
            if (empty($booking->duration_hours) && $booking->start_time && $booking->end_time) {
                $start = Carbon::parse($booking->start_time);
                $end = Carbon::parse($booking->end_time);
                $booking->duration_hours = $end->diffInMinutes($start) / 60;
            }
        });

        static::updating(function ($booking) {
            // Recalculate duration if times changed
            if ($booking->isDirty(['start_time', 'end_time'])) {
                $start = Carbon::parse($booking->start_time);
                $end = Carbon::parse($booking->end_time);
                $booking->duration_hours = $end->diffInMinutes($start) / 60;
            }
        });
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function parentBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'parent_booking_id');
    }

    public function childBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'parent_booking_id');
    }

    /**
     * Scopes
     */
    public function scopeByLab($query, $labId)
    {
        return $query->where('laboratory_id', $labId);
    }

    public function scopeByEquipment($query, $equipmentId)
    {
        return $query->where('equipment_id', $equipmentId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['completed', 'cancelled', 'no_show'])
            ->orderBy('booking_date')
            ->orderBy('start_time');
    }

    public function scopeToday($query)
    {
        return $query->where('booking_date', now()->toDateString());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'checked_in', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('booking_date', [$startDate, $endDate]);
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'confirmed' => 'Dikonfirmasi',
            'checked_in' => 'Sudah Check-in',
            'in_progress' => 'Sedang Berlangsung',
            'checked_out' => 'Sudah Check-out',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'no_show' => 'Tidak Hadir',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'confirmed' => 'primary',
            'checked_in' => 'success',
            'in_progress' => 'success',
            'checked_out' => 'secondary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'danger',
            default => 'secondary',
        };
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->booking_date->format('d F Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        $start = Carbon::parse($this->start_time)->format('H:i');
        $end = Carbon::parse($this->end_time)->format('H:i');
        return "{$start} - {$end}";
    }

    /**
     * Generate unique booking number
     */
    public static function generateBookingNumber(): string
    {
        $date = now()->format('Ymd');
        $lastBooking = static::where('booking_number', 'like', "BOOK-{$date}-%")
            ->orderBy('booking_number', 'desc')
            ->first();

        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->booking_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('BOOK-%s-%04d', $date, $newNumber);
    }

    /**
     * Approve booking
     */
    public function approve(int $userId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);
    }

    /**
     * User confirms approved booking
     */
    public function confirm(): void
    {
        if ($this->status !== 'approved') {
            throw new \Exception('Only approved bookings can be confirmed');
        }

        $this->update(['status' => 'confirmed']);
    }

    /**
     * Cancel booking
     */
    public function cancel(int $userId, string $reason): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_by' => $userId,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        // Cancel child bookings if recurring
        if ($this->is_recurring) {
            $this->childBookings()->update([
                'status' => 'cancelled',
                'cancelled_by' => $userId,
                'cancelled_at' => now(),
                'cancellation_reason' => 'Parent booking cancelled: ' . $reason,
            ]);
        }
    }

    /**
     * Check-in
     */
    public function checkIn(int $userId): void
    {
        if (!in_array($this->status, ['confirmed', 'approved'])) {
            throw new \Exception('Only confirmed or approved bookings can be checked in');
        }

        $this->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => $userId,
        ]);
    }

    /**
     * Check-out
     */
    public function checkOut(int $userId): void
    {
        if ($this->status !== 'checked_in') {
            throw new \Exception('Must check-in before check-out');
        }

        $this->update([
            'status' => 'checked_out',
            'checked_out_at' => now(),
            'checked_out_by' => $userId,
        ]);

        // Auto-complete after checkout
        $this->complete();
    }

    /**
     * Mark as no-show
     */
    public function markAsNoShow(int $userId): void
    {
        $this->update([
            'status' => 'no_show',
            'cancelled_by' => $userId,
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Complete booking
     */
    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Detect booking conflicts
     */
    public function detectConflicts(): array
    {
        $conflicts = [];

        // Check laboratory conflicts
        $labConflict = static::where('laboratory_id', $this->laboratory_id)
            ->where('booking_date', $this->booking_date)
            ->where('id', '!=', $this->id ?? 0)
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                    ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                    ->orWhere(function ($q) {
                        $q->where('start_time', '<=', $this->start_time)
                          ->where('end_time', '>=', $this->end_time);
                    });
            })
            ->with('user')
            ->get();

        if ($labConflict->isNotEmpty()) {
            $conflicts['laboratory'] = $labConflict;
        }

        // Check equipment conflicts if equipment specified
        if ($this->equipment_id) {
            $equipConflict = static::where('equipment_id', $this->equipment_id)
                ->where('booking_date', $this->booking_date)
                ->where('id', '!=', $this->id ?? 0)
                ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
                ->where(function ($query) {
                    $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                        ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                        ->orWhere(function ($q) {
                            $q->where('start_time', '<=', $this->start_time)
                              ->where('end_time', '>=', $this->end_time);
                        });
                })
                ->with('user')
                ->get();

            if ($equipConflict->isNotEmpty()) {
                $conflicts['equipment'] = $equipConflict;
            }
        }

        return $conflicts;
    }

    /**
     * Generate recurring bookings
     */
    public function generateRecurringBookings(): void
    {
        if (!$this->is_recurring || !$this->recurrence_pattern || !$this->recurrence_end_date) {
            return;
        }

        $currentDate = Carbon::parse($this->booking_date);
        $endDate = Carbon::parse($this->recurrence_end_date);

        while ($currentDate->lt($endDate)) {
            // Increment date based on pattern
            $currentDate = match($this->recurrence_pattern) {
                'daily' => $currentDate->addDay(),
                'weekly' => $currentDate->addWeek(),
                'monthly' => $currentDate->addMonth(),
                default => $currentDate->addDay(), // Default fallback
            };

            if ($currentDate->gt($endDate)) {
                break;
            }

            // Create child booking
            $child = $this->replicate();
            $child->booking_date = $currentDate->toDateString();
            $child->parent_booking_id = $this->id;
            $child->booking_number = static::generateBookingNumber();
            $child->is_recurring = false; // Child bookings are not recurring themselves
            $child->save();
        }
    }

    /**
     * Check if booking can be checked in
     */
    public function canCheckIn(): bool
    {
        if (!in_array($this->status, ['confirmed', 'approved'])) {
            return false;
        }

        if ($this->booking_date->isToday()) {
            $now = now();
            $startTime = Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s'));

            // Can check in 15 minutes before start time
            return $now->diffInMinutes($startTime, false) <= 15;
        }

        return false;
    }

    /**
     * Check if booking can be checked out
     */
    public function canCheckOut(): bool
    {
        return $this->status === 'checked_in';
    }

    /**
     * Get booking type label
     */
    public function getBookingTypeLabelAttribute(): string
    {
        return match($this->booking_type) {
            'research' => 'Penelitian',
            'testing' => 'Pengujian',
            'training' => 'Pelatihan',
            'maintenance' => 'Pemeliharaan',
            'other' => 'Lainnya',
            default => 'Unknown',
        };
    }
}
