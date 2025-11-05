<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegistrationCode extends Model
{
    protected $fillable = [
        'code',
        'email',
        'user_type',
        'max_uses',
        'used_count',
        'expires_at',
        'is_active',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Check if code is valid and can be used
     */
    public function isValid(string $email = null): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check if expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check if max uses reached
        if ($this->used_count >= $this->max_uses) {
            return false;
        }

        // Check if email-specific code matches
        if ($this->email && $email && $this->email !== $email) {
            return false;
        }

        return true;
    }

    /**
     * Mark code as used
     */
    public function markAsUsed(): void
    {
        $this->increment('used_count');

        // Deactivate if max uses reached
        if ($this->used_count >= $this->max_uses) {
            $this->update(['is_active' => false]);
        }
    }

    /**
     * Generate a new registration code
     */
    public static function generate(array $attributes = []): self
    {
        return self::create(array_merge([
            'code' => strtoupper(Str::random(8)),
            'user_type' => 'external',
            'max_uses' => 1,
            'used_count' => 0,
            'is_active' => true,
        ], $attributes));
    }

    /**
     * Relationship: Created by user
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Active codes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }
}
