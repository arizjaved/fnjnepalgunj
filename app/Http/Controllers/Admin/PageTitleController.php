<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageTitleController extends Controller
{
    /**
     * Display the page titles management interface.
     */
    public function index()
    {
        $pageTitles = $this->getPageTitles();
        
        return view('admin.page-titles.index', compact('pageTitles'));
    }

    /**
     * Update the page titles.
     */
    public function update(Request $request)
    {
        $request->validate([
            'titles' => 'required|array',
            'titles.*' => 'required|string|max:255',
        ]);

        // Store the page titles in a JSON file
        $pageTitles = $request->input('titles');
        
        // Save to storage
        Storage::disk('local')->put('page-titles.json', json_encode($pageTitles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        // Clear cache
        Cache::forget('page_titles');
        
        return redirect()->route('admin.page-titles.index')
                        ->with('success', 'Page titles updated successfully!');
    }

    /**
     * Get the current page titles from storage or defaults.
     */
    private function getPageTitles()
    {
        return Cache::remember('page_titles', 3600, function () {
            $defaultTitles = [
                'home' => [
                    'label' => 'Homepage Title',
                    'description' => 'Main title for the homepage',
                    'current' => 'गृहपृष्ठ - नेपाल पत्रकार महासंघ'
                ],
                'news' => [
                    'label' => 'News Page Title',
                    'description' => 'Title for the news listing page',
                    'current' => 'समाचार - नेपाल पत्रकार महासंघ'
                ],
                'press_release' => [
                    'label' => 'Press Release Page Title',
                    'description' => 'Title for the press release page',
                    'current' => 'प्रेस विज्ञप्ति - नेपाल पत्रकार महासंघ'
                ],
                'notice' => [
                    'label' => 'Notice Page Title',
                    'description' => 'Title for the notice page',
                    'current' => 'सूचना - नेपाल पत्रकार महासंघ'
                ],
                'photo_gallery' => [
                    'label' => 'Photo Gallery Title',
                    'description' => 'Title for the photo gallery page',
                    'current' => 'फोटो ग्यालरी - नेपाल पत्रकार महासंघ'
                ],
                'video_gallery' => [
                    'label' => 'Video Gallery Title',
                    'description' => 'Title for the video gallery page',
                    'current' => 'भिडियो ग्यालरी - नेपाल पत्रकार महासंघ'
                ],
                'membership' => [
                    'label' => 'Membership Page Title',
                    'description' => 'Title for the membership page',
                    'current' => 'सदस्यता - नेपाल पत्रकार महासंघ'
                ],
                'grievance' => [
                    'label' => 'Grievance Page Title',
                    'description' => 'Title for the grievance/complaint page',
                    'current' => 'उजुरी - नेपाल पत्रकार महासंघ'
                ],
                'contact' => [
                    'label' => 'Contact Page Title',
                    'description' => 'Title for the contact page',
                    'current' => 'सम्पर्क - नेपाल पत्रकार महासंघ'
                ],
                'economic_activity' => [
                    'label' => 'Economic Activity Page Title',
                    'description' => 'Title for the economic activity page',
                    'current' => 'आर्थिक गतिविधि - नेपाल पत्रकार महासंघ'
                ]
            ];

            // Try to load from storage
            if (Storage::disk('local')->exists('page-titles.json')) {
                $storedTitles = json_decode(Storage::disk('local')->get('page-titles.json'), true);
                
                if ($storedTitles) {
                    // Merge stored titles with defaults, updating the 'current' values
                    foreach ($defaultTitles as $key => $titleData) {
                        if (isset($storedTitles[$key])) {
                            $defaultTitles[$key]['current'] = $storedTitles[$key];
                        }
                    }
                }
            }

            return $defaultTitles;
        });
    }

    /**
     * Get a specific page title by key.
     */
    public static function getPageTitle($key, $default = null)
    {
        $pageTitles = Cache::remember('page_titles', 3600, function () {
            if (Storage::disk('local')->exists('page-titles.json')) {
                return json_decode(Storage::disk('local')->get('page-titles.json'), true) ?: [];
            }
            return [];
        });

        return $pageTitles[$key] ?? $default;
    }
}