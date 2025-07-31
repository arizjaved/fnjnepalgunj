<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactContent extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'contact_info',
        'office_hours',
        'social_links',
        'map_embed',
        'banner_image',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'office_hours' => 'array',
        'social_links' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image) {
            return asset('storage/' . $this->banner_image);
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
