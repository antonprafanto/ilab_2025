<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Sop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'category',
        'laboratory_id',
        'version',
        'revision_number',
        'purpose',
        'scope',
        'description',
        'steps',
        'requirements',
        'safety_precautions',
        'references',
        'document_file',
        'attachments',
        'status',
        'prepared_by',
        'reviewed_by',
        'approved_by',
        'review_date',
        'approval_date',
        'effective_date',
        'next_review_date',
        'review_interval_months',
        'revision_notes',
        'change_history',
    ];

    protected $casts = [
        'steps' => 'array',
        'attachments' => 'array',
        'change_history' => 'array',
        'review_date' => 'date',
        'approval_date' => 'date',
        'effective_date' => 'date',
        'next_review_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the laboratory that owns the SOP
     */
    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    /**
     * Get the user who prepared the SOP
     */
    public function preparer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    /**
     * Get the user who reviewed the SOP
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the user who approved the SOP
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: Filter by category
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Approved SOPs
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Draft SOPs
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: SOPs needing review
     */
    public function scopeNeedsReview($query, $daysAhead = 30)
    {
        return $query->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', Carbon::now()->addDays($daysAhead));
    }

    /**
     * Scope: Effective SOPs (approved and effective date has passed)
     */
    public function scopeEffective($query)
    {
        return $query->where('status', 'approved')
            ->whereNotNull('effective_date')
            ->where('effective_date', '<=', Carbon::now());
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'equipment' => 'Penggunaan Alat',
            'testing' => 'Pengujian',
            'safety' => 'Keselamatan',
            'quality' => 'Mutu/Kualitas',
            'maintenance' => 'Pemeliharaan',
            'calibration' => 'Kalibrasi',
            'general' => 'Umum',
            default => $this->category,
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'review' => 'Dalam Review',
            'approved' => 'Disetujui',
            'archived' => 'Diarsipkan',
            default => $this->status,
        };
    }

    /**
     * Get status badge variant
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft' => 'default',
            'review' => 'info',
            'approved' => 'success',
            'archived' => 'danger',
            default => 'default',
        };
    }

    /**
     * Get document file URL
     */
    public function getDocumentUrlAttribute(): ?string
    {
        if ($this->document_file) {
            return asset('storage/' . $this->document_file);
        }
        return null;
    }

    /**
     * Check if review is overdue
     */
    public function getIsReviewOverdueAttribute(): bool
    {
        return $this->next_review_date && $this->next_review_date < Carbon::now();
    }

    /**
     * Check if SOP is currently effective
     */
    public function getIsEffectiveAttribute(): bool
    {
        return $this->status === 'approved'
            && $this->effective_date
            && $this->effective_date <= Carbon::now();
    }

    /**
     * Get days until next review
     */
    public function getDaysUntilReviewAttribute(): ?int
    {
        if (!$this->next_review_date) {
            return null;
        }
        return Carbon::now()->diffInDays($this->next_review_date, false);
    }

    /**
     * Get full version string (version + revision)
     */
    public function getFullVersionAttribute(): string
    {
        return $this->version . ($this->revision_number > 0 ? ' Rev.' . $this->revision_number : '');
    }
}
