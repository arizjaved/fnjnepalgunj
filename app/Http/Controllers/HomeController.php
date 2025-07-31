<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use App\Models\PressRelease;
use App\Models\Notice;
use App\Helpers\SettingsHelper;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured news for carousel
        $featuredNews = News::published()
                           ->featured()
                           ->with('creator')
                           ->orderBy('published_at', 'desc')
                           ->limit(5)
                           ->get();
        
        // Get latest news for homepage (limit to 3 as requested)
        $latestNews = News::published()
                         ->with('creator')
                         ->when($featuredNews->isNotEmpty(), function($query) use ($featuredNews) {
                             return $query->whereNotIn('id', $featuredNews->pluck('id'));
                         })
                         ->orderBy('published_at', 'desc')
                         ->limit(3)
                         ->get();
        
        // Get latest press releases (limit to 3)
        $pressReleases = PressRelease::published()
                                   ->orderBy('published_at', 'desc')
                                   ->limit(3)
                                   ->get();
        
        // Get latest notices (limit to 5)
        $notices = Notice::published()
                         ->orderBy('published_at', 'desc')
                         ->limit(5)
                         ->get();
        
        // Get photo gallery items (limit to 4)
        $photoGallery = PhotoGallery::active()
                                   ->ordered()
                                   ->limit(4)
                                   ->get();
        
        // Get video gallery items (limit to 5)
        $videoGallery = VideoGallery::active()
                                   ->ordered()
                                   ->limit(5)
                                   ->get();
        
        // Get chairman's message settings
        $chairmanSettings = [
            'name' => SettingsHelper::get('chairman_name', 'श्री बिपुल पोखरेल'),
            'position' => SettingsHelper::get('chairman_position', 'अध्यक्ष'),
            'photo' => SettingsHelper::get('chairman_photo'),
            'message' => SettingsHelper::get('chairman_message', ''),
            'enabled' => SettingsHelper::get('chairman_message_enabled', '1') === '1',
        ];
        
        // Get social media embed codes
        $socialSettings = [
            'facebook_embed' => SettingsHelper::get('facebook_embed', ''),
            'twitter_embed' => SettingsHelper::get('twitter_embed', ''),
        ];
        
        return view('home', compact(
            'latestNews', 
            'featuredNews', 
            'photoGallery', 
            'videoGallery',
            'pressReleases',
            'notices',
            'chairmanSettings',
            'socialSettings'
        ));
    }
}
