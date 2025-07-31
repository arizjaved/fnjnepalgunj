<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'name',
        'filename',
        'path',
        'mime_type',
        'size',
        'type',
        'metadata',
        'alt_text',
        'description',
        'uploaded_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'size' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getHumanSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getIsImageAttribute()
    {
        return $this->type === 'image';
    }

    public function getIsDocumentAttribute()
    {
        return $this->type === 'document';
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->is_image) {
            return $this->url;
        }
        
        // Return default thumbnails for different file types
        $iconMap = [
            'document' => 'images/icons/document.svg',
            'video' => 'images/icons/video.svg',
            'audio' => 'images/icons/audio.svg',
        ];
        
        return asset($iconMap[$this->type] ?? 'images/icons/file.svg');
    }

    public static function getTypeFromMimeType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'document';
        }
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeDocuments($query)
    {
        return $query->where('type', 'document');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
