<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutPage extends Model
{
    protected $fillable = [
        'title',
        'main_content',
        'vision',
        'mission',
        'objectives',
        'quick_facts',
        'leadership_positions',
        'hero_image',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'main_content' => 'array',
        'mission' => 'array',
        'objectives' => 'array',
        'quick_facts' => 'array',
        'leadership_positions' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getHeroImageUrlAttribute()
    {
        if ($this->hero_image) {
            return asset('storage/' . $this->hero_image);
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}