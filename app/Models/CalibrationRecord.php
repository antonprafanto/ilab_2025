<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class CalibrationRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_id',
        'calibration_code',
        'type',
        'method',
        'calibration_date',
        'due_date',
        'interval_months',
        'status',
        'result',
        'measurement_results',
        'test_points',
        'deviations',
        'adjustments_made',
        'accuracy',
        'uncertainty',
        'range_calibrated',
        'standards_used',
        'equipment_used',
        'reference_conditions',
        'calibrated_by',
        'verified_by',
        'external_lab',
        'certificate_number',
        'certificate_issue_date',
        'certificate_expiry_date',
        'certificate_file',
        'calibration_cost',
        'next_calibration_date',
        'recommendations',
        'notes',
        'attachments',
    ];

    protected $casts = [
        'calibration_date' => 'date',
        'due_date' => 'date',
        'test_points' => 'array',
        'deviations' => 'array',
        'certificate_issue_date' => 'date',
        'certificate_expiry_date' => 'date',
        'calibration_cost' => 'decimal:2',
        'next_calibration_date' => 'date',
        'attachments' => 'array',
        'deleted_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function calibrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calibrated_by');
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

    public function scopeOfResult($query, $result)
    {
        return $query->where('result', $result);
    }

    public function scopePassed($query)
    {
        return $query->where('result', 'pass');
    }

    public function scopeFailed($query)
    {
        return $query->where('result', 'fail');
    }

    public function scopeInternal($query)
    {
        return $query->where('type', 'internal');
    }

    public function scopeExternal($query)
    {
        return $query->where('type', 'external');
    }

    public function scopeDueSoon($query, $days = 30)
    {
        return $query->whereNotNull('due_date')
            ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays($days)]);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
            ->where('due_date', '<', Carbon::today());
    }

    // ==================== ACCESSORS ====================

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'internal' => 'Kalibrasi Internal',
            'external' => 'Kalibrasi Eksternal',
            'verification' => 'Verifikasi',
            'adjustment' => 'Penyesuaian',
            default => $this->type,
        };
    }

    public function getMethodLabelAttribute(): ?string
    {
        return match($this->method) {
            'comparison' => 'Perbandingan dengan Standar',
            'direct' => 'Pengukuran Langsung',
            'simulation' => 'Simulasi',
            'functional' => 'Pengujian Fungsi',
            default => $this->method,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'Dijadwalkan',
            'in_progress' => 'Sedang Dikerjakan',
            'passed' => 'Lulus',
            'failed' => 'Tidak Lulus',
            'conditional' => 'Lulus Bersyarat',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'info',
            'in_progress' => 'warning',
            'passed' => 'success',
            'failed' => 'danger',
            'conditional' => 'warning',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    public function getResultLabelAttribute(): ?string
    {
        if (!$this->result) {
            return null;
        }

        return match($this->result) {
            'pass' => 'Lulus',
            'fail' => 'Tidak Lulus',
            'conditional' => 'Lulus Bersyarat',
            default => $this->result,
        };
    }

    public function getResultBadgeAttribute(): ?string
    {
        if (!$this->result) {
            return null;
        }

        return match($this->result) {
            'pass' => 'success',
            'fail' => 'danger',
            'conditional' => 'warning',
            default => 'secondary',
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast();
    }

    public function getIsDueSoonAttribute(): bool
    {
        return $this->due_date
            && $this->due_date->isFuture()
            && $this->due_date->diffInDays(Carbon::today()) <= 30;
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        if (!$this->due_date) {
            return null;
        }
        return Carbon::today()->diffInDays($this->due_date, false);
    }

    public function getCertificateUrlAttribute(): ?string
    {
        return $this->certificate_file
            ? asset('storage/' . $this->certificate_file)
            : null;
    }

    public function getIsCertificateValidAttribute(): bool
    {
        return $this->certificate_expiry_date && $this->certificate_expiry_date->isFuture();
    }
}
