<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public static function get($key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        Cache::forget("site_setting_{$key}");
        return $setting;
    }

    public static function getByGroup($group)
    {
        return Cache::remember("site_settings_group_{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function clearCache()
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("site_setting_{$key}");
        }
        
        $groups = static::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("site_settings_group_{$group}");
        }
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saved(function () {
            static::clearCache();
        });
        
        static::deleted(function () {
            static::clearCache();
        });
    }
}
