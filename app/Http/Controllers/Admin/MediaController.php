<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Media::with('uploader');
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('alt_text', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // MIME type filter
        if ($request->filled('mime_type')) {
            $query->where('mime_type', $request->mime_type);
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(24);
        
        // Preserve query parameters in pagination links
        $media->appends($request->query());
        
        // Get statistics
        $stats = [
            'total' => Media::count(),
            'images' => Media::where('type', 'image')->count(),
            'documents' => Media::where('type', 'document')->count(),
            'videos' => Media::where('type', 'video')->count(),
            'total_size' => Media::sum('size'),
        ];
        
        return view('admin.media.index', compact('media', 'stats'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB max per file
            'alt_text.*' => 'nullable|string|max:255',
            'description.*' => 'nullable|string|max:1000',
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $size = $file->getSize();
                $type = Media::getTypeFromMimeType($mimeType);
                
                // Generate unique filename
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Store file
                $path = $file->storeAs('media', $filename, 'public');
                
                // Get image dimensions if it's an image
                $metadata = [];
                if ($type === 'image') {
                    $imagePath = storage_path('app/public/' . $path);
                    if (file_exists($imagePath)) {
                        $imageSize = getimagesize($imagePath);
                        if ($imageSize) {
                            $metadata = [
                                'width' => $imageSize[0],
                                'height' => $imageSize[1],
                            ];
                        }
                    }
                }
                
                $media = Media::create([
                    'name' => $originalName,
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'size' => $size,
                    'type' => $type,
                    'metadata' => $metadata,
                    'alt_text' => $request->input("alt_text.{$index}"),
                    'description' => $request->input("description.{$index}"),
                    'uploaded_by' => Auth::id(),
                ]);
                
                $uploadedFiles[] = $media;
            }
        }

        $count = count($uploadedFiles);
        return redirect()->route('admin.media.index')
                        ->with('success', "{$count} file(s) uploaded successfully.");
    }

    public function show(Media $media)
    {
        return view('admin.media.show', compact('media'));
    }

    public function edit(Media $media)
    {
        return view('admin.media.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $media->update($validated);

        return redirect()->route('admin.media.index')
                        ->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        // Delete the physical file
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
                        ->with('success', 'Media deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:media,id'
        ]);

        $mediaItems = Media::whereIn('id', $validated['selected_items'])->get();
        
        foreach ($mediaItems as $media) {
            // Delete the physical file
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
            $media->delete();
        }

        $count = $mediaItems->count();
        return redirect()->route('admin.media.index')
                        ->with('success', "{$count} media file(s) deleted successfully.");
    }

    public function download(Media $media)
    {
        if (!Storage::disk('public')->exists($media->path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($media->path, $media->name);
    }
}
