<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_number',
        'user_id',
        'service_id',
        'title',
        'description',
        'priority',
        'is_urgent',
        'urgency_reason',
        'sample_count',
        'sample_type',
        'sample_description',
        'sample_preparation',
        'sample_details',
        'research_title',
        'research_objective',
        'institution',
        'department',
        'supervisor_name',
        'supervisor_contact',
        'proposal_file',
        'supporting_documents',
        'preferred_date',
        'preferred_time',
        'estimated_completion_date',
        'actual_completion_date',
        'status',
        'status_notes',
        'internal_notes',
        'submitted_at',
        'verified_at',
        'approved_at',
        'assigned_at',
        'lab_assigned_at',
        'completed_at',
        'assigned_to',
        'assigned_to_lab_id',
        'verified_by',
        'approved_by',
        'sla_deadline_verification',
        'sla_deadline_approval',
        'sla_deadline_assignment',
        'quoted_price',
        'final_price',
        'is_paid',
        'notes',
        'rejection_reason',
        'view_count',
    ];

    protected $casts = [
        'sample_details' => 'array',
        'supporting_documents' => 'array',
        'is_urgent' => 'boolean',
        'is_paid' => 'boolean',
        'preferred_date' => 'date',
        'preferred_time' => 'datetime',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'assigned_at' => 'datetime',
        'lab_assigned_at' => 'datetime',
        'completed_at' => 'datetime',
        'sla_deadline_verification' => 'datetime',
        'sla_deadline_approval' => 'datetime',
        'sla_deadline_assignment' => 'datetime',
        'quoted_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'sample_count' => 'integer',
        'view_count' => 'integer',
    ];

    /**
     * Boot method - generate request number automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($request) {
            if (empty($request->request_number)) {
                $request->request_number = static::generateRequestNumber();
            }
            if (empty($request->submitted_at)) {
                $request->submitted_at = now();
            }
            // Set initial SLA deadline for verification (24 hours from submission)
            if (empty($request->sla_deadline_verification)) {
                $request->sla_deadline_verification = now()->addHours(24);
            }
        });

        // Auto-set SLA deadlines on status change
        static::updating(function ($request) {
            if ($request->isDirty('status')) {
                switch ($request->status) {
                    case 'verified':
                        if (empty($request->verified_at)) {
                            $request->verified_at = now();
                        }
                        // Set deadline for approval (24h from verification)
                        $request->sla_deadline_approval = now()->addHours(24);
                        break;

                    case 'approved':
                        if (empty($request->approved_at)) {
                            $request->approved_at = now();
                        }
                        // Set deadline for assignment (24h from approval)
                        $request->sla_deadline_assignment = now()->addHours(24);
                        break;
                }
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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedLaboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'assigned_to_lab_id');
    }

    /**
     * Scopes
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['verified', 'approved', 'assigned', 'in_progress', 'testing']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeAssignedToUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('request_number', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('service', function ($service) use ($search) {
                    $service->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'approved' => 'Disetujui',
            'assigned' => 'Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'testing' => 'Sedang Analisis',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'verified' => 'info',
            'approved' => 'success',
            'assigned' => 'primary',
            'in_progress', 'testing' => 'primary',
            'completed' => 'success',
            'rejected', 'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getPriorityLabelAttribute()
    {
        return match ($this->priority) {
            'urgent' => 'Mendesak',
            'standard' => 'Standar',
            default => ucfirst($this->priority),
        };
    }

    public function getPriorityBadgeAttribute()
    {
        return match ($this->priority) {
            'urgent' => 'danger',
            'standard' => 'secondary',
            default => 'secondary',
        };
    }

    public function getProposalFileUrlAttribute()
    {
        if ($this->proposal_file && file_exists(storage_path('app/public/' . $this->proposal_file))) {
            return asset('storage/' . $this->proposal_file);
        }
        return null;
    }

    public function getDaysUntilCompletionAttribute()
    {
        if (!$this->estimated_completion_date) {
            return null;
        }
        return now()->diffInDays($this->estimated_completion_date, false);
    }

    public function getIsOverdueAttribute()
    {
        if (!$this->estimated_completion_date || in_array($this->status, ['completed', 'rejected', 'cancelled'])) {
            return false;
        }
        return now()->gt($this->estimated_completion_date);
    }

    /**
     * Static Methods
     */
    public static function generateRequestNumber()
    {
        $date = now()->format('Ymd');
        $prefix = 'SR-' . $date . '-';

        // Get last request number for today
        $lastRequest = static::where('request_number', 'like', $prefix . '%')
            ->orderBy('request_number', 'desc')
            ->first();

        if ($lastRequest) {
            $lastNumber = (int) substr($lastRequest->request_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Instance Methods
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function canBeEdited()
    {
        return $this->status === 'pending';
    }

    public function canBeCancelled()
    {
        return !in_array($this->status, ['completed', 'rejected', 'cancelled']);
    }

    public function markAsVerified($verifierId)
    {
        $this->update([
            'status' => 'verified',
            'verified_by' => $verifierId,
            'verified_at' => now(),
        ]);
    }

    public function markAsApproved($approverId)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approverId,
            'approved_at' => now(),
        ]);
    }

    public function assignTo($userId)
    {
        $this->update([
            'status' => 'assigned',
            'assigned_to' => $userId,
            'assigned_at' => now(),
        ]);
    }

    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
        ]);
    }

    public function markAsTesting()
    {
        $this->update([
            'status' => 'testing',
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'actual_completion_date' => now(),
        ]);
    }

    public function markAsRejected($reason)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Calculate estimated completion date based on service duration
     */
    public function calculateEstimatedCompletion()
    {
        if (!$this->service) {
            return null;
        }

        $workingDays = $this->service->duration_days;

        // If urgent, reduce by 30%
        if ($this->is_urgent) {
            $workingDays = ceil($workingDays * 0.7);
        }

        $estimatedDate = now();
        $daysAdded = 0;

        while ($daysAdded < $workingDays) {
            $estimatedDate->addDay();
            // Skip weekends (Saturday = 6, Sunday = 0)
            if (!in_array($estimatedDate->dayOfWeek, [0, 6])) {
                $daysAdded++;
            }
        }

        return $estimatedDate->toDateString();
    }

    /**
     * Get timeline events for tracking
     */
    public function getTimelineEvents()
    {
        $events = [];

        if ($this->submitted_at) {
            $events[] = [
                'date' => $this->submitted_at,
                'title' => 'Permohonan Diajukan',
                'description' => 'Permohonan layanan telah disubmit',
                'status' => 'pending',
                'icon' => 'fa-paper-plane',
            ];
        }

        if ($this->verified_at) {
            $events[] = [
                'date' => $this->verified_at,
                'title' => 'Terverifikasi',
                'description' => 'Permohonan telah diverifikasi oleh admin',
                'status' => 'verified',
                'icon' => 'fa-check-circle',
            ];
        }

        if ($this->approved_at) {
            $events[] = [
                'date' => $this->approved_at,
                'title' => 'Disetujui',
                'description' => 'Permohonan telah disetujui',
                'status' => 'approved',
                'icon' => 'fa-thumbs-up',
            ];
        }

        if ($this->assigned_at) {
            $events[] = [
                'date' => $this->assigned_at,
                'title' => 'Ditugaskan',
                'description' => 'Permohonan telah ditugaskan ke ' . ($this->assignedTo->name ?? 'Kepala Lab'),
                'status' => 'assigned',
                'icon' => 'fa-user-check',
            ];
        }

        if ($this->status === 'in_progress') {
            $events[] = [
                'date' => $this->updated_at,
                'title' => 'Sedang Dikerjakan',
                'description' => 'Pengujian sedang dalam proses',
                'status' => 'in_progress',
                'icon' => 'fa-cogs',
            ];
        }

        if ($this->status === 'testing') {
            $events[] = [
                'date' => $this->updated_at,
                'title' => 'Sedang Analisis',
                'description' => 'Analisis sampel sedang dilakukan',
                'status' => 'testing',
                'icon' => 'fa-flask',
            ];
        }

        if ($this->completed_at) {
            $events[] = [
                'date' => $this->completed_at,
                'title' => 'Selesai',
                'description' => 'Pengujian telah selesai',
                'status' => 'completed',
                'icon' => 'fa-check-double',
            ];
        }

        if ($this->status === 'rejected') {
            $events[] = [
                'date' => $this->updated_at,
                'title' => 'Ditolak',
                'description' => 'Permohonan ditolak: ' . $this->rejection_reason,
                'status' => 'rejected',
                'icon' => 'fa-times-circle',
            ];
        }

        return $events;
    }

    /**
     * Internal Notes System
     */
    public function addInternalNote(string $note, int $userId): void
    {
        $existingNotes = $this->internal_notes ? json_decode($this->internal_notes, true) : [];

        $existingNotes[] = [
            'note' => $note,
            'user_id' => $userId,
            'user_name' => User::find($userId)?->name,
            'created_at' => now()->toDateTimeString(),
        ];

        $this->update(['internal_notes' => json_encode($existingNotes)]);
    }

    public function getInternalNotesArray(): array
    {
        return $this->internal_notes ? json_decode($this->internal_notes, true) : [];
    }

    /**
     * SLA Tracking System
     */
    public function calculateSLAStatus(string $stage): array
    {
        $deadlineField = "sla_deadline_{$stage}";
        $deadline = $this->$deadlineField;

        if (!$deadline) {
            return ['status' => 'N/A', 'color' => 'gray', 'hours' => 0];
        }

        $hoursRemaining = now()->diffInHours($deadline, false);

        if ($hoursRemaining < 0) {
            return [
                'status' => 'Overdue',
                'color' => 'red',
                'hours' => abs($hoursRemaining),
                'message' => 'Melewati deadline ' . abs($hoursRemaining) . ' jam yang lalu'
            ];
        } elseif ($hoursRemaining < 8) {
            return [
                'status' => 'Warning',
                'color' => 'yellow',
                'hours' => $hoursRemaining,
                'message' => 'Sisa waktu ' . round($hoursRemaining, 1) . ' jam'
            ];
        } else {
            return [
                'status' => 'On Time',
                'color' => 'green',
                'hours' => $hoursRemaining,
                'message' => 'Sisa waktu ' . round($hoursRemaining, 1) . ' jam'
            ];
        }
    }

    public function getCurrentSLAStatus(): ?array
    {
        // Determine which SLA to check based on current status
        if ($this->status === 'pending') {
            return $this->calculateSLAStatus('verification');
        } elseif ($this->status === 'verified') {
            return $this->calculateSLAStatus('approval');
        } elseif ($this->status === 'approved') {
            return $this->calculateSLAStatus('assignment');
        }

        return null;
    }
}
