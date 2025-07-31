<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'document_file',
        'document_name',
        'document_type',
        'document_size',
        'status',
        'published_at',
        'valid_until',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'valid_until' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($notice) {
            if (empty($notice->slug)) {
                $notice->slug = Str::slug($notice->title);
            }
        });
        
        static::updating(function ($notice) {
            if ($notice->isDirty('title') && empty($notice->getOriginal('slug'))) {
                $notice->slug = Str::slug($notice->title);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeActive($query)
    {
        return $query->published()
                    ->where(function($q) {
                        $q->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', now()->toDateString());
                    });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDocumentUrlAttribute()
    {
        if ($this->document_file) {
            return asset('storage/' . $this->document_file);
        }
        return null;
    }

    public function getDocumentSizeFormattedAttribute()
    {
        if (!$this->document_size) {
            return null;
        }
        
        $bytes = $this->document_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getIsExpiredAttribute()
    {
        return $this->valid_until && $this->valid_until < now()->toDateString();
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'published' && 
               $this->published_at <= now() && 
               (!$this->valid_until || $this->valid_until >= now()->toDateString());
    }
}
