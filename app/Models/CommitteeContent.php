<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeContent extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'term_info',
        'responsibilities',
        'contact_info',
        'section_titles',
        'banner_image',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'term_info' => 'array',
        'responsibilities' => 'array',
        'contact_info' => 'array',
        'section_titles' => 'array',
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