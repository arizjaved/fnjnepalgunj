<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutPage;

class AboutController extends Controller
{
    public function index()
    {
        $aboutPage = AboutPage::active()->first();
        
        if (!$aboutPage) {
            // Create default data if none exists
            $defaultData = config('site.about_page_data');
            $aboutPage = AboutPage::create([
                'title' => 'हाम्रो बारेमा',
                'main_content' => $defaultData['main_content'] ?? [],
                'vision' => $defaultData['vision_mission']['vision'] ?? '',
                'mission' => $defaultData['vision_mission']['mission'] ?? [],
                'objectives' => $defaultData['objectives'] ?? [],
                'quick_facts' => $defaultData['sidebar']['quick_facts']['facts'] ?? [],
                'leadership_positions' => $defaultData['sidebar']['leadership']['positions'] ?? [],
                'status' => 'active',
                'created_by' => 1,
            ]);
        }

        // Structure data for frontend - ensure arrays are always returned
        $aboutData = [
            'main_content' => is_array($aboutPage->main_content) ? $aboutPage->main_content : [],
            'vision_mission' => [
                'vision' => $aboutPage->vision ?? '',
                'mission' => is_array($aboutPage->mission) ? $aboutPage->mission : []
            ],
            'objectives' => is_array($aboutPage->objectives) ? $aboutPage->objectives : [],
            'sidebar' => [
                'quick_facts' => [
                    'title' => 'तथ्याङ्कहरू',
                    'facts' => is_array($aboutPage->quick_facts) ? $aboutPage->quick_facts : []
                ],
                'leadership' => [
                    'title' => 'नेतृत्व',
                    'positions' => is_array($aboutPage->leadership_positions) ? $aboutPage->leadership_positions : []
                ]
            ]
        ];

        return view('about', compact('aboutData'));
    }
}
