<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoGallery;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        $photos = PhotoGallery::with(['category', 'creator'])
                             ->orderBy('sort_order')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);
        
        return view('admin.photo-gallery.index', compact('photos'));
    }

    public function create()
    {
        $categories = MediaCategory::active()->forPhotos()->orderBy('name')->get();
        return view('admin.photo-gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:media_categories,id',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('photo-gallery', 'public');
        }

        PhotoGallery::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image_path' => $imagePath,
            'image_alt' => $request->image_alt ?: $request->title,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?: 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.photo-gallery.index')
                        ->with('success', 'Photo added successfully.');
    }

    public function show(PhotoGallery $photoGallery)
    {
        $photoGallery->load(['category', 'creator', 'updater']);
        return view('admin.photo-gallery.show', compact('photoGallery'));
    }

    public function edit(PhotoGallery $photoGallery)
    {
        $categories = MediaCategory::active()->forPhotos()->orderBy('name')->get();
        return view('admin.photo-gallery.edit', compact('photoGallery', 'categories'));
    }

    public function update(Request $request, PhotoGallery $photoGallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:media_categories,id',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'image_alt' => $request->image_alt ?: $request->title,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?: 0,
            'updated_by' => auth()->id(),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($photoGallery->image_path) {
                Storage::disk('public')->delete($photoGallery->image_path);
            }
            
            $data['image_path'] = $request->file('image')->store('photo-gallery', 'public');
        }

        $photoGallery->update($data);

        return redirect()->route('admin.photo-gallery.index')
                        ->with('success', 'Photo updated successfully.');
    }

    public function destroy(PhotoGallery $photoGallery)
    {
        // Delete image file
        if ($photoGallery->image_path) {
            Storage::disk('public')->delete($photoGallery->image_path);
        }

        $photoGallery->delete();

        return redirect()->route('admin.photo-gallery.index')
                        ->with('success', 'Photo deleted successfully.');
    }
}