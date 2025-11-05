<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Reagent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'laboratory_id', 'code', 'name', 'cas_number', 'formula', 'category', 'grade', 'purity',
        'manufacturer', 'lot_number', 'quantity', 'unit', 'storage_location', 'storage_conditions',
        'hazard_class', 'safety_notes', 'sds_file', 'purchase_date', 'expiry_date', 'opened_date',
        'status', 'min_stock_level', 'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
        'opened_date' => 'date',
        'quantity' => 'decimal:2',
        'min_stock_level' => 'decimal:2',
    ];

    public function laboratory(): BelongsTo { return $this->belongsTo(Laboratory::class); }

    public function scopeOfCategory($query, $category) { return $query->where('category', $category); }
    public function scopeOfStatus($query, $status) { return $query->where('status', $status); }
    public function scopeOfHazard($query, $hazard) { return $query->where('hazard_class', $hazard); }
    public function scopeExpired($query) { return $query->where('expiry_date', '<', Carbon::now())->whereNotIn('status', ['disposed']); }
    public function scopeLowStock($query) { return $query->whereRaw('quantity <= min_stock_level')->where('status', 'available'); }

    public function getCategoryLabelAttribute(): string {
        return match($this->category) {
            'acid' => 'Asam', 'base' => 'Basa', 'salt' => 'Garam', 'organic' => 'Organik',
            'inorganic' => 'Anorganik', 'solvent' => 'Pelarut', 'indicator' => 'Indikator',
            'standard' => 'Standar', 'other' => 'Lainnya', default => ucfirst($this->category),
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'available' => 'Tersedia', 'in_use' => 'Digunakan', 'low_stock' => 'Stok Rendah',
            'expired' => 'Kadaluarsa', 'disposed' => 'Dibuang', default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'available' => 'success', 'in_use' => 'primary', 'low_stock' => 'warning',
            'expired' => 'danger', 'disposed' => 'secondary', default => 'secondary',
        };
    }

    public function getHazardLabelAttribute(): string {
        return match($this->hazard_class) {
            'non_hazardous' => 'Tidak Berbahaya', 'flammable' => 'Mudah Terbakar', 'corrosive' => 'Korosif',
            'toxic' => 'Beracun', 'oxidizing' => 'Oksidator', 'explosive' => 'Eksplosif',
            'radioactive' => 'Radioaktif', default => ucfirst($this->hazard_class),
        };
    }

    public function getHazardBadgeAttribute(): string {
        return match($this->hazard_class) {
            'non_hazardous' => 'success', 'flammable' => 'warning', 'corrosive' => 'danger',
            'toxic' => 'danger', 'oxidizing' => 'warning', 'explosive' => 'danger',
            'radioactive' => 'danger', default => 'secondary',
        };
    }

    public function getIsExpiredAttribute(): bool {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getIsLowStockAttribute(): bool {
        return $this->min_stock_level && $this->quantity <= $this->min_stock_level;
    }

    public function getSdsFileUrlAttribute(): ?string {
        return $this->sds_file ? asset('storage/' . $this->sds_file) : null;
    }
}
