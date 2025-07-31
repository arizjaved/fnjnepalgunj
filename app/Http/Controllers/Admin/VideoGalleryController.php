<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $videos = VideoGallery::with(['category', 'creator'])
                             ->orderBy('sort_order')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);
        
        return view('admin.video-gallery.index', compact('videos'));
    }

    public function create()
    {
        $categories = MediaCategory::active()->forVideos()->orderBy('name')->get();
        return view('admin.video-gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_embed_code' => 'required|string',
            'duration' => 'nullable|string|max:20',
            'category_id' => 'nullable|exists:media_categories,id',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        VideoGallery::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'youtube_embed_code' => $request->youtube_embed_code,
            'duration' => $request->duration,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?: 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.video-gallery.index')
                        ->with('success', 'Video added successfully.');
    }

    public function show(VideoGallery $videoGallery)
    {
        $videoGallery->load(['category', 'creator', 'updater']);
        return view('admin.video-gallery.show', compact('videoGallery'));
    }

    public function edit(VideoGallery $videoGallery)
    {
        $categories = MediaCategory::active()->forVideos()->orderBy('name')->get();
        return view('admin.video-gallery.edit', compact('videoGallery', 'categories'));
    }

    public function update(Request $request, VideoGallery $videoGallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_embed_code' => 'required|string',
            'duration' => 'nullable|string|max:20',
            'category_id' => 'nullable|exists:media_categories,id',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $videoGallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'youtube_embed_code' => $request->youtube_embed_code,
            'duration' => $request->duration,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?: 0,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.video-gallery.index')
                        ->with('success', 'Video updated successfully.');
    }

    public function destroy(VideoGallery $videoGallery)
    {
        $videoGallery->delete();

        return redirect()->route('admin.video-gallery.index')
                        ->with('success', 'Video deleted successfully.');
    }
}