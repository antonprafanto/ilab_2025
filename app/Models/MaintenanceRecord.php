<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MaintenanceRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_id',
        'maintenance_code',
        'type',
        'priority',
        'scheduled_date',
        'completed_date',
        'start_time',
        'end_time',
        'duration_hours',
        'status',
        'description',
        'work_performed',
        'parts_replaced',
        'findings',
        'recommendations',
        'performed_by',
        'verified_by',
        'labor_cost',
        'parts_cost',
        'total_cost',
        'attachments',
        'next_maintenance_date',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'attachments' => 'array',
        'labor_cost' => 'decimal:2',
        'parts_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'next_maintenance_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ==================== QUERY SCOPES ====================

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOfPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_date', '<', Carbon::today());
    }

    public function scopeUpcoming($query, $days = 30)
    {
        return $query->where('status', 'scheduled')
            ->whereBetween('scheduled_date', [Carbon::today(), Carbon::today()->addDays($days)]);
    }

    // ==================== ACCESSORS ====================

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'preventive' => 'Pemeliharaan Preventif',
            'corrective' => 'Pemeliharaan Korektif',
            'breakdown' => 'Perbaikan Kerusakan',
            'inspection' => 'Inspeksi Rutin',
            'cleaning' => 'Pembersihan',
            'calibration' => 'Kalibrasi',
            'replacement' => 'Penggantian Parts',
            default => $this->type,
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak',
            default => $this->priority,
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => 'secondary',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'Dijadwalkan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'postponed' => 'Ditunda',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'info',
            'in_progress' => 'warning',
            'completed' => 'success',
            'cancelled' => 'secondary',
            'postponed' => 'warning',
            default => 'secondary',
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'scheduled'
            && $this->scheduled_date->isPast();
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->status === 'scheduled'
            && $this->scheduled_date->isFuture()
            && $this->scheduled_date->diffInDays(Carbon::today()) <= 7;
    }

    public function getDaysUntilScheduledAttribute(): ?int
    {
        if ($this->status !== 'scheduled') {
            return null;
        }
        return Carbon::today()->diffInDays($this->scheduled_date, false);
    }
}
