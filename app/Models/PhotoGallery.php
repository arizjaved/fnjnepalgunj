<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PhotoGallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'image_alt',
        'category_id',
        'status',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($photo) {
            if (empty($photo->slug)) {
                $photo->slug = Str::slug($photo->title);
            }
        });
        
        static::updating(function ($photo) {
            if ($photo->isDirty('title') && empty($photo->getOriginal('slug'))) {
                $photo->slug = Str::slug($photo->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MediaCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}