<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MediaCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->getOriginal('slug'))) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function photoGalleries(): HasMany
    {
        return $this->hasMany(PhotoGallery::class, 'category_id');
    }

    public function videoGalleries(): HasMany
    {
        return $this->hasMany(VideoGallery::class, 'category_id');
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPhotos($query)
    {
        return $query->whereIn('type', ['photo', 'both']);
    }

    public function scopeForVideos($query)
    {
        return $query->whereIn('type', ['video', 'both']);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}