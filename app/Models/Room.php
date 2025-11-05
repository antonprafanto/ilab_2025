<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'laboratory_id',
        'code',
        'name',
        'type',
        'area',
        'capacity',
        'status',
        'description',
        'facilities',
        'floor',
        'building',
        'responsible_person',
        'safety_equipment',
        'notes',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'capacity' => 'integer',
    ];

    /**
     * Relationships
     */
    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function responsiblePerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_person');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeInLaboratory($query, $laboratoryId)
    {
        return $query->where('laboratory_id', $laboratoryId);
    }

    /**
     * Accessors
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'research' => 'Ruang Penelitian',
            'teaching' => 'Ruang Pengajaran',
            'storage' => 'Ruang Penyimpanan',
            'preparation' => 'Ruang Persiapan',
            'meeting' => 'Ruang Rapat',
            'office' => 'Ruang Kantor',
            default => ucfirst($this->type),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'maintenance' => 'Maintenance',
            'inactive' => 'Tidak Aktif',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'maintenance' => 'warning',
            'inactive' => 'danger',
            default => 'secondary',
        };
    }

    public function getFullLocationAttribute(): string
    {
        $location = [];

        if ($this->building) {
            $location[] = "Gedung {$this->building}";
        }

        if ($this->floor) {
            $location[] = "Lantai {$this->floor}";
        }

        return !empty($location) ? implode(', ', $location) : '-';
    }
}
