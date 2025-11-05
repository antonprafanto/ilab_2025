<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'laboratory_id',
        'code',
        'name',
        'description',
        'category',
        'subcategory',
        'method',
        'duration_days',
        'price_internal',
        'price_external_edu',
        'price_external',
        'urgent_surcharge_percent',
        'requirements',
        'equipment_needed',
        'sample_preparation',
        'deliverables',
        'min_sample',
        'max_sample',
        'is_active',
        'popularity',
    ];

    protected $casts = [
        'requirements' => 'array',
        'equipment_needed' => 'array',
        'deliverables' => 'array',
        'is_active' => 'boolean',
        'popularity' => 'integer',
        'duration_days' => 'integer',
        'min_sample' => 'integer',
        'max_sample' => 'integer',
        'urgent_surcharge_percent' => 'integer',
        'price_internal' => 'decimal:2',
        'price_external_edu' => 'decimal:2',
        'price_external' => 'decimal:2',
    ];

    /**
     * Relationship: Service belongs to Laboratory
     */
    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    /**
     * Scope: Only active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by laboratory
     */
    public function scopeLaboratory($query, $laboratoryId)
    {
        return $query->where('laboratory_id', $laboratoryId);
    }

    /**
     * Scope: Popular services (sorted by popularity DESC)
     */
    public function scopePopular($query)
    {
        return $query->orderBy('popularity', 'desc');
    }

    /**
     * Scope: Search by name, code, or description
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Accessor: Get formatted price for specific user type
     *
     * @param string $userType internal|external_edu|external
     * @return string
     */
    public function getPriceForUserType($userType = 'external')
    {
        return match($userType) {
            'internal' => $this->price_internal,
            'external_edu' => $this->price_external_edu,
            default => $this->price_external,
        };
    }

    /**
     * Calculate price with discount
     *
     * @param string $userType
     * @param int $discountPercent
     * @param bool $isUrgent
     * @return float
     */
    public function calculatePrice($userType = 'external', $discountPercent = 0, $isUrgent = false)
    {
        $basePrice = $this->getPriceForUserType($userType);

        // Apply discount
        $priceAfterDiscount = $basePrice * (1 - ($discountPercent / 100));

        // Apply urgent surcharge if needed
        if ($isUrgent) {
            $priceAfterDiscount = $priceAfterDiscount * (1 + ($this->urgent_surcharge_percent / 100));
        }

        return round($priceAfterDiscount, 2);
    }

    /**
     * Increment popularity counter
     */
    public function incrementPopularity()
    {
        $this->increment('popularity');
    }

    /**
     * Accessor: Get category label (Indonesian)
     */
    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'kimia' => 'Kimia',
            'biologi' => 'Biologi',
            'fisika' => 'Fisika',
            'mikrobiologi' => 'Mikrobiologi',
            'material' => 'Material',
            'lingkungan' => 'Lingkungan',
            'pangan' => 'Pangan',
            'farmasi' => 'Farmasi',
            default => ucfirst($this->category),
        };
    }

    /**
     * Get category badge color
     */
    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'kimia' => 'blue',
            'biologi' => 'green',
            'fisika' => 'purple',
            'mikrobiologi' => 'pink',
            'material' => 'gray',
            'lingkungan' => 'teal',
            'pangan' => 'orange',
            'farmasi' => 'red',
            default => 'gray',
        };
    }
}
