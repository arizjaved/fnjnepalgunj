<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::active()->with('creator')->orderBy('published_at', 'desc');
        
        // Add search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('document_name', 'like', "%{$searchTerm}%");
            });
        }
        
        $notices = $query->paginate(10);
        
        // Get sidebar data
        $pressReleases = \App\Models\PressRelease::published()
                                               ->orderBy('published_at', 'desc')
                                               ->limit(3)
                                               ->get();
        
        return view('notice', compact('notices', 'pressReleases'));
    }

    public function show($slug)
    {
        $notice = Notice::active()
                       ->with(['creator', 'updater'])
                       ->where('slug', $slug)
                       ->firstOrFail();
        
        // Get related notices
        $relatedNotices = Notice::active()
                               ->where('id', '!=', $notice->id)
                               ->orderBy('published_at', 'desc')
                               ->limit(5)
                               ->get();
        
        return view('notice-detail', compact('notice', 'relatedNotices'));
    }

    public function download($slug)
    {
        $notice = Notice::active()
                       ->where('slug', $slug)
                       ->firstOrFail();
        
        if (!$notice->document_file) {
            abort(404, 'Document not found');
        }
        
        $filePath = storage_path('app/public/' . $notice->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        return response()->download($filePath, $notice->document_name);
    }
}