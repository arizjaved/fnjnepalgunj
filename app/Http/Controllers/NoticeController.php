<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\PressRelease;
use App\Http\Controllers\Admin\PageTitleController;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        // Create page content object with default values
        $pageContent = (object) [
            'title' => 'सूचना',
            'subtitle' => null,
            'description' => null,
            'featured_image' => null,
            'meta_title' => PageTitleController::getPageTitle('notice', 'सूचना - नेपाल पत्रकार महासंघ'),
            'meta_description' => 'नेपाल पत्रकार महासंघका सूचनाहरू'
        ];
        
        $query = Notice::published()->with('creator')->orderBy('published_at', 'desc');
        
        // Add search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        $notices = $query->paginate(12);

        $pressReleases = PressRelease::published()->orderBy('published_at', 'desc')->limit(5)->get();
        
        return view('notice', compact('notices', 'pageContent', 'pressReleases'));
    }


    public function show($slug)
    {
        $notice = Notice::published()
                      ->with(['creator', 'updater'])
                      ->where('slug', $slug)
                      ->firstOrFail();
        
        // Get related notices (recent)
        $relatedNotices = Notice::published()
                          ->where('id', '!=', $notice->id)
                          ->orderBy('published_at', 'desc')
                          ->limit(4)
                          ->get();
        
        return view('notice-detail', compact('notice', 'relatedNotices'));
    }

    public function download($slug)
    {
        $notice = Notice::published()->where('slug', $slug)->firstOrFail();

        if (!$notice->document_file || !\Illuminate\Support\Facades\Storage::disk('public')->exists($notice->document_file)) {
            abort(404, 'File not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($notice->document_file, $notice->slug . '.' . pathinfo($notice->document_file, PATHINFO_EXTENSION));
    }
}
