<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'location',
        'area_sqm',
        'capacity',
        'photo',
        'head_user_id',
        'phone',
        'email',
        'operating_hours_start',
        'operating_hours_end',
        'operating_days',
        'status',
        'status_notes',
        'facilities',
        'certifications',
    ];

    protected $casts = [
        'operating_days' => 'array',
        'facilities' => 'array',
        'certifications' => 'array',
        'operating_hours_start' => 'datetime',
        'operating_hours_end' => 'datetime',
        'area_sqm' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the head/kepala lab user
     */
    public function headUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    /**
     * Get equipment in this laboratory
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Get services provided by this laboratory
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get rooms in this laboratory
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Scope for active laboratories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get lab type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'chemistry' => 'Kimia',
            'biology' => 'Biologi',
            'physics' => 'Fisika',
            'geology' => 'Geologi',
            'engineering' => 'Teknik',
            'computer' => 'Komputer',
            'other' => 'Lainnya',
            default => $this->type,
        };
    }

    /**
     * Get status badge variant
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'maintenance' => 'warning',
            'closed' => 'danger',
            default => 'default',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'maintenance' => 'Maintenance',
            'closed' => 'Tutup',
            default => $this->status,
        };
    }

    /**
     * Get photo URL
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        // Return data URI for placeholder SVG
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="300" fill="#0066CC"/>
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">
                    Lab Photo
                </text>
            </svg>
        ');
    }
}
