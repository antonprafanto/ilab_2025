<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'title',
        'academic_degree',
        'bio',
        'expertise',
        'phone_office',
        'phone_mobile',
        'email_alternate',
        'website',
        'department',
        'faculty',
        'position',
        'employment_status',
        'id_card_number',
        'tax_id',
        'address_office',
        'city',
        'province',
        'postal_code',
        'country',
        'linkedin',
        'google_scholar',
        'researchgate',
        'orcid',
        'language',
        'timezone',
        'email_notifications',
        'sms_notifications',
        'last_profile_update',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'last_profile_update' => 'datetime',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full academic title with name.
     * Format: [Title] Name[, Academic Degree]
     * Example: Dr. Anton Prafanto, S.Kom., M.T.
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->user->name;

        // Add title prefix (Dr., Prof., H., Hj., etc.)
        if ($this->title) {
            $name = $this->title . ' ' . $name;
        }

        // Add academic degree suffix (S.Kom., M.T., Ph.D., etc.)
        if ($this->academic_degree) {
            $name = $name . ', ' . $this->academic_degree;
        }

        return $name;
    }

    /**
     * Get avatar URL or default.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Default avatar using UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&size=200&background=0066CC&color=ffffff';
    }
}
