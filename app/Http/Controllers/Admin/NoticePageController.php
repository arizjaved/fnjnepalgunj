<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NoticePageController extends Controller
{
    private const SETTINGS_CACHE_KEY = 'notice_page_settings';
    private const SETTINGS_FILE_PATH = 'page-settings/notice-page.json';

    public function index()
    {
        $pageSettings = $this->getNoticePageSettings();
        
        return view('admin.notice-page.index', compact('pageSettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $settings = $this->getNoticePageSettings();
        
        // Update settings with validated data, excluding the file
        $settings = array_merge($settings, $validated);

        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists
            if (!empty($settings['featured_image']) && Storage::disk('public')->exists($settings['featured_image'])) {
                Storage::disk('public')->delete($settings['featured_image']);
            }
            // Store new image in public storage
            $path = $request->file('featured_image')->store('page-headers', 'public');
            $settings['featured_image'] = $path;
        }

        // Save settings to a JSON file in local storage
        Storage::disk('local')->put(self::SETTINGS_FILE_PATH, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        // Clear the cache to reflect changes immediately
        Cache::forget(self::SETTINGS_CACHE_KEY);
        
        return redirect()->route('admin.notice-page.index')
                        ->with('success', 'Notice page settings updated successfully!');
    }

    private function getNoticePageSettings()
    {
        return Cache::remember(self::SETTINGS_CACHE_KEY, 3600, function () {
            $defaultSettings = [
                'title' => 'सूचना',
                'meta_title' => 'सूचना - नेपाल पत्रकार महासंघ',
                'meta_description' => 'नेपाल पत्रकार महासंघका सूचनाहरू',
                'subtitle' => null,
                'description' => null,
                'featured_image' => null
            ];

            if (!Storage::disk('local')->exists(self::SETTINGS_FILE_PATH)) {
                return $defaultSettings;
            }

            $storedSettings = json_decode(Storage::disk('local')->get(self::SETTINGS_FILE_PATH), true);
            
            return array_merge($defaultSettings, $storedSettings ?: []);
        });
    }
}