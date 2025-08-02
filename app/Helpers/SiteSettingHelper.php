<?php

if (!function_exists('site_setting')) {
    /**
     * Get a site setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function site_setting($key, $default = null)
    {
        try {
            return \App\Models\SiteSetting::get($key, $default);
        } catch (\Exception $e) {
            // Fallback to direct database query if cache fails
            try {
                $setting = \App\Models\SiteSetting::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            } catch (\Exception $e) {
                return $default;
            }
        }
    }
}

if (!function_exists('site_settings')) {
    /**
     * Get all site settings as an array
     *
     * @return array
     */
    function site_settings()
    {
        return \App\Models\SiteSetting::pluck('value', 'key')->toArray();
    }
}

if (!function_exists('site_setting_by_group')) {
    /**
     * Get site settings by group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    function site_setting_by_group($group)
    {
        return \App\Models\SiteSetting::where('group', $group)->pluck('value', 'key');
    }
}