<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class VideoGallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'youtube_embed_code',
        'youtube_video_id',
        'thumbnail_url',
        'duration',
        'category_id',
        'status',
        'sort_order',
        'views',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($video) {
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
            }
            
            // Extract video ID from YouTube embed code
            if ($video->youtube_embed_code && empty($video->youtube_video_id)) {
                $video->youtube_video_id = self::extractYouTubeVideoId($video->youtube_embed_code);
            }
            
            // Generate thumbnail URL if not provided
            if ($video->youtube_video_id && empty($video->thumbnail_url)) {
                $video->thumbnail_url = "https://img.youtube.com/vi/{$video->youtube_video_id}/maxresdefault.jpg";
            }
        });
        
        static::updating(function ($video) {
            if ($video->isDirty('title') && empty($video->getOriginal('slug'))) {
                $video->slug = Str::slug($video->title);
            }
            
            // Update video ID if embed code changed
            if ($video->isDirty('youtube_embed_code')) {
                $video->youtube_video_id = self::extractYouTubeVideoId($video->youtube_embed_code);
                if ($video->youtube_video_id) {
                    $video->thumbnail_url = "https://img.youtube.com/vi/{$video->youtube_video_id}/maxresdefault.jpg";
                }
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

    public function getEmbedUrlAttribute()
    {
        if ($this->youtube_video_id) {
            return "https://www.youtube.com/embed/{$this->youtube_video_id}";
        }
        return null;
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public static function extractYouTubeVideoId($embedCode)
    {
        // Extract video ID from various YouTube URL formats
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $embedCode, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}