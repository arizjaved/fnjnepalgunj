<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Publication extends Model
{
    protected $fillable = [
        'title',
        'type',
        'document_file',
        'document_name',
        'document_type',
        'document_size',
        'status',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($publication) {
            if ($publication->status === 'published' && !$publication->published_at) {
                $publication->published_at = now();
            }
        });
        
        static::updating(function ($publication) {
            if ($publication->isDirty('status') && $publication->status === 'published' && !$publication->published_at) {
                $publication->published_at = now();
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
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopePublications($query)
    {
        return $query->where('type', 'publication');
    }

    public function scopeEconomicActivities($query)
    {
        return $query->where('type', 'economic_activity');
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

    public function getTypeDisplayAttribute()
    {
        return $this->type === 'publication' ? 'प्रकाशनहरू' : 'आर्थिक गतिविधि';
    }
}
