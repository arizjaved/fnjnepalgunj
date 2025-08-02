<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Controllers\Admin\PageTitleController;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // Create page content object with default values
        $pageContent = (object) [
            'title' => 'समाचार',
            'subtitle' => null,
            'description' => null,
            'featured_image' => null,
            'meta_title' => PageTitleController::getPageTitle('news', 'समाचार - नेपाल पत्रकार महासंघ'),
            'meta_description' => 'नेपाल पत्रकार महासंघका समाचारहरू'
        ];
        
        $query = News::published()->with('creator')->orderBy('published_at', 'desc');
        
        // Add search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        $news = $query->paginate(12);
        
        return view('news', compact('news', 'pageContent'));
    }


    public function show($slug)
    {
        $article = News::published()
                      ->with(['creator', 'updater'])
                      ->where('slug', $slug)
                      ->firstOrFail();
        
        // Get related news (same category or recent)
        $relatedNews = News::published()
                          ->where('id', '!=', $article->id)
                          ->orderBy('published_at', 'desc')
                          ->limit(4)
                          ->get();
        
        return view('news-detail', compact('article', 'relatedNews'));
    }
}
