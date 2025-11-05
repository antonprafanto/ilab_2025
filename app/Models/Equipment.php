<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'laboratory_id',
        'category',
        'brand',
        'model',
        'serial_number',
        'description',
        'specifications',
        'photo',
        'purchase_date',
        'purchase_price',
        'supplier',
        'warranty_period',
        'warranty_until',
        'condition',
        'status',
        'status_notes',
        'last_maintenance',
        'next_maintenance',
        'maintenance_interval_days',
        'last_calibration',
        'next_calibration',
        'calibration_interval_days',
        'location_detail',
        'assigned_to',
        'usage_count',
        'usage_hours',
        'manual_file',
        'documents',
    ];

    protected $casts = [
        'specifications' => 'array',
        'documents' => 'array',
        'purchase_date' => 'date',
        'warranty_until' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'last_calibration' => 'date',
        'next_calibration' => 'date',
        'purchase_price' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the laboratory that owns the equipment
     */
    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    /**
     * Get the user assigned to this equipment
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get maintenance records
     */
    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    /**
     * Get calibration records
     */
    public function calibrationRecords(): HasMany
    {
        return $this->hasMany(CalibrationRecord::class);
    }

    /**
     * Scope: Available equipment
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope: Filter by laboratory
     */
    public function scopeInLaboratory($query, $laboratoryId)
    {
        return $query->where('laboratory_id', $laboratoryId);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Needs maintenance (overdue or due soon)
     */
    public function scopeNeedsMaintenance($query, $daysAhead = 7)
    {
        return $query->whereNotNull('next_maintenance')
            ->where('next_maintenance', '<=', Carbon::now()->addDays($daysAhead));
    }

    /**
     * Scope: Needs calibration (overdue or due soon)
     */
    public function scopeNeedsCalibration($query, $daysAhead = 7)
    {
        return $query->whereNotNull('next_calibration')
            ->where('next_calibration', '<=', Carbon::now()->addDays($daysAhead));
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'analytical' => 'Analitik',
            'measurement' => 'Pengukuran',
            'preparation' => 'Preparasi',
            'safety' => 'Safety',
            'computer' => 'Komputer',
            'general' => 'Umum',
            default => $this->category,
        };
    }

    /**
     * Get condition label
     */
    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'Sangat Baik',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'poor' => 'Buruk',
            'broken' => 'Rusak',
            default => $this->condition,
        };
    }

    /**
     * Get condition badge variant
     */
    public function getConditionBadgeAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'success',
            'good' => 'primary',
            'fair' => 'warning',
            'poor' => 'danger',
            'broken' => 'danger',
            default => 'default',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'in_use' => 'Sedang Digunakan',
            'maintenance' => 'Maintenance',
            'calibration' => 'Kalibrasi',
            'broken' => 'Rusak',
            'retired' => 'Retired',
            default => $this->status,
        };
    }

    /**
     * Get status badge variant
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => 'success',
            'in_use' => 'info',
            'maintenance' => 'warning',
            'calibration' => 'warning',
            'broken' => 'danger',
            'retired' => 'default',
            default => 'default',
        };
    }

    /**
     * Get photo URL with SVG placeholder
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Return inline SVG data URI sebagai placeholder
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="300" fill="#FF9800"/>
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">
                    Equipment Photo
                </text>
            </svg>
        ');
    }

    /**
     * Check if warranty is still valid
     */
    public function getIsUnderWarrantyAttribute(): bool
    {
        return $this->warranty_until && $this->warranty_until >= Carbon::now();
    }

    /**
     * Check if maintenance is overdue
     */
    public function getIsMaintenanceOverdueAttribute(): bool
    {
        return $this->next_maintenance && $this->next_maintenance < Carbon::now();
    }

    /**
     * Check if calibration is overdue
     */
    public function getIsCalibrationOverdueAttribute(): bool
    {
        return $this->next_calibration && $this->next_calibration < Carbon::now();
    }

    /**
     * Get days until next maintenance
     */
    public function getDaysUntilMaintenanceAttribute(): ?int
    {
        if (!$this->next_maintenance) {
            return null;
        }
        return Carbon::now()->diffInDays($this->next_maintenance, false);
    }

    /**
     * Get days until next calibration
     */
    public function getDaysUntilCalibrationAttribute(): ?int
    {
        if (!$this->next_calibration) {
            return null;
        }
        return Carbon::now()->diffInDays($this->next_calibration, false);
    }
}
