<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoGallery;
use App\Models\MediaCategory;

class VideoGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoGallery::active()->with('category')->ordered();
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $videos = $query->paginate(12);
        $categories = MediaCategory::active()->forVideos()->withCount('videoGalleries')->orderBy('name')->get();
        
        return view('video-gallery', compact('videos', 'categories'));
    }

    public function show(VideoGallery $videoGallery)
    {
        // Increment view count
        $videoGallery->incrementViews();
        
        $videoGallery->load('category');
        
        // Get related videos
        $relatedVideos = VideoGallery::active()
                                   ->where('id', '!=', $videoGallery->id)
                                   ->when($videoGallery->category_id, function($q) use ($videoGallery) {
                                       $q->where('category_id', $videoGallery->category_id);
                                   })
                                   ->ordered()
                                   ->limit(6)
                                   ->get();
        
        return view('video-detail', compact('videoGallery', 'relatedVideos'));
    }
}