<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Sample extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'laboratory_id', 'code', 'name', 'type', 'source', 'storage_location', 'storage_condition',
        'status', 'received_date', 'expiry_date', 'quantity', 'unit', 'submitted_by', 'analyzed_by',
        'description', 'test_parameters', 'analysis_results', 'result_file', 'analysis_date',
        'result_date', 'priority', 'special_requirements', 'notes',
    ];

    protected $casts = [
        'received_date' => 'date',
        'expiry_date' => 'date',
        'analysis_date' => 'date',
        'result_date' => 'date',
        'quantity' => 'decimal:2',
    ];

    public function laboratory(): BelongsTo { return $this->belongsTo(Laboratory::class); }
    public function submitter(): BelongsTo { return $this->belongsTo(User::class, 'submitted_by'); }
    public function analyzer(): BelongsTo { return $this->belongsTo(User::class, 'analyzed_by'); }

    public function scopeOfType($query, $type) { return $query->where('type', $type); }
    public function scopeOfStatus($query, $status) { return $query->where('status', $status); }
    public function scopeOfPriority($query, $priority) { return $query->where('priority', $priority); }
    public function scopeInLaboratory($query, $labId) { return $query->where('laboratory_id', $labId); }
    public function scopeExpiringSoon($query, $days = 30) {
        return $query->where('expiry_date', '<=', Carbon::now()->addDays($days))
                     ->where('expiry_date', '>=', Carbon::now())
                     ->whereNotIn('status', ['disposed', 'archived']);
    }
    public function scopeExpired($query) {
        return $query->where('expiry_date', '<', Carbon::now())->whereNotIn('status', ['disposed', 'archived']);
    }

    public function getTypeLabelAttribute(): string {
        return match($this->type) {
            'biological' => 'Biologis', 'chemical' => 'Kimia', 'environmental' => 'Lingkungan',
            'food' => 'Pangan', 'pharmaceutical' => 'Farmasi', 'other' => 'Lainnya',
            default => ucfirst($this->type),
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'received' => 'Diterima', 'in_analysis' => 'Dalam Analisis', 'completed' => 'Selesai',
            'archived' => 'Diarsipkan', 'disposed' => 'Dibuang', default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'received' => 'secondary', 'in_analysis' => 'warning', 'completed' => 'success',
            'archived' => 'secondary', 'disposed' => 'danger', default => 'secondary',
        };
    }

    public function getPriorityLabelAttribute(): string {
        return match($this->priority) {
            'low' => 'Rendah', 'normal' => 'Normal', 'high' => 'Tinggi', 'urgent' => 'Mendesak',
            default => ucfirst($this->priority),
        };
    }

    public function getPriorityBadgeAttribute(): string {
        return match($this->priority) {
            'low' => 'secondary', 'normal' => 'primary', 'high' => 'warning', 'urgent' => 'danger',
            default => 'secondary',
        };
    }

    public function getStorageConditionLabelAttribute(): string {
        return match($this->storage_condition) {
            'room_temperature' => 'Suhu Ruang', 'refrigerated' => 'Didinginkan',
            'frozen' => 'Dibekukan', 'special' => 'Kondisi Khusus',
            default => ucfirst($this->storage_condition),
        };
    }

    public function getIsExpiredAttribute(): bool {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->isFuture() && $this->expiry_date->diffInDays(Carbon::now()) <= 30;
    }

    public function getDaysUntilExpiryAttribute(): ?int {
        if (!$this->expiry_date) return null;
        return $this->expiry_date->isPast()
            ? -1 * $this->expiry_date->diffInDays(Carbon::now())
            : $this->expiry_date->diffInDays(Carbon::now());
    }

    public function getResultFileUrlAttribute(): ?string {
        return $this->result_file ? asset('storage/' . $this->result_file) : null;
    }
}
