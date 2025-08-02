<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageTitleHelper
{
    /**
     * Get a page title by key.
     */
    public static function getTitle($key, $default = null)
    {
        $pageTitles = Cache::remember('page_titles', 3600, function () {
            $defaults = [
                'home' => 'गृहपृष्ठ - नेपाल पत्रकार महासंघ',
                'news' => 'समाचार - नेपाल पत्रकार महासंघ',
                'press_release' => 'प्रेस विज्ञप्ति - नेपाल पत्रकार महासंघ',
                'notice' => 'सूचना - नेपाल पत्रकार महासंघ',
                'photo_gallery' => 'फोटो ग्यालरी - नेपाल पत्रकार महासंघ',
                'video_gallery' => 'भिडियो ग्यालरी - नेपाल पत्रकार महासंघ',
                'membership' => 'सदस्यता - नेपाल पत्रकार महासंघ',
                'grievance' => 'उजुरी - नेपाल पत्रकार महासंघ',
                'contact' => 'सम्पर्क - नेपाल पत्रकार महासंघ',
                'economic_activity' => 'आर्थिक गतिविधि - नेपाल पत्रकार महासंघ'
            ];

            if (Storage::disk('local')->exists('page-titles.json')) {
                $storedTitles = json_decode(Storage::disk('local')->get('page-titles.json'), true);
                if ($storedTitles && is_array($storedTitles)) {
                    return array_merge($defaults, $storedTitles);
                }
            }

            return $defaults;
        });

        return $pageTitles[$key] ?? $default ?? 'नेपाल पत्रकार महासंघ';
    }

    /**
     * Clear the page titles cache.
     */
    public static function clearCache()
    {
        Cache::forget('page_titles');
    }
}