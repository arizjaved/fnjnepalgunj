<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PressRelease;
use App\Http\Controllers\Admin\PageTitleController;

class PressReleaseController extends Controller
{
    public function index(Request $request)
    {
        // Create page content object with default values
        $pageContent = (object) [
            'title' => 'प्रेस विज्ञप्ति',
            'subtitle' => null,
            'description' => null,
            'featured_image' => null,
            'meta_title' => PageTitleController::getPageTitle('press_release', 'प्रेस विज्ञप्ति - नेपाल पत्रकार महासंघ'),
            'meta_description' => 'नेपाल पत्रकार महासंघका प्रेस विज्ञप्तिहरू'
        ];
        
        $query = PressRelease::published()->with('creator')->orderBy('published_at', 'desc');
        
        // Add search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        $pressReleases = $query->paginate(12);
        
        // Get sidebar data
        $notices = \App\Models\Notice::active()
                                    ->orderBy('published_at', 'desc')
                                    ->limit(3)
                                    ->get();
        
        return view('press-release', compact('pressReleases', 'notices', 'pageContent'));
    }

    public function show($slug)
    {
        $pressRelease = PressRelease::published()
                                  ->with(['creator', 'updater'])
                                  ->where('slug', $slug)
                                  ->firstOrFail();
        
        // Get related press releases
        $relatedPressReleases = PressRelease::published()
                                          ->where('id', '!=', $pressRelease->id)
                                          ->orderBy('published_at', 'desc')
                                          ->limit(4)
                                          ->get();
        
        return view('press-release-detail', compact('pressRelease', 'relatedPressReleases'));
    }

    public function download($slug)
    {
        $pressRelease = PressRelease::published()
                                  ->where('slug', $slug)
                                  ->firstOrFail();

        if (!$pressRelease->document_file || !\Illuminate\Support\Facades\Storage::disk('public')->exists($pressRelease->document_file)) {
            abort(404, 'Document not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $pressRelease->document_file,
            $pressRelease->document_name ?: 'press-release-document.' . $pressRelease->document_type
        );
    }
}