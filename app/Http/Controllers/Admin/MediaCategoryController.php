<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaCategoryController extends Controller
{
    public function index()
    {
        $categories = MediaCategory::withCount(['photoGalleries', 'videoGalleries'])
                                  ->orderBy('name')
                                  ->paginate(15);
        
        return view('admin.media-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.media-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:media_categories,name',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video,both',
            'is_active' => 'boolean',
        ]);

        MediaCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.media-categories.index')
                        ->with('success', 'Category created successfully.');
    }

    public function show(MediaCategory $mediaCategory)
    {
        $mediaCategory->load(['photoGalleries', 'videoGalleries']);
        return view('admin.media-categories.show', compact('mediaCategory'));
    }

    public function edit(MediaCategory $mediaCategory)
    {
        return view('admin.media-categories.edit', compact('mediaCategory'));
    }

    public function update(Request $request, MediaCategory $mediaCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:media_categories,name,' . $mediaCategory->id,
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video,both',
            'is_active' => 'boolean',
        ]);

        $mediaCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.media-categories.index')
                        ->with('success', 'Category updated successfully.');
    }

    public function destroy(MediaCategory $mediaCategory)
    {
        // Check if category is in use
        $photoCount = $mediaCategory->photoGalleries()->count();
        $videoCount = $mediaCategory->videoGalleries()->count();
        
        if ($photoCount > 0 || $videoCount > 0) {
            return redirect()->route('admin.media-categories.index')
                            ->with('error', 'Cannot delete category that is in use by media items.');
        }

        $mediaCategory->delete();

        return redirect()->route('admin.media-categories.index')
                        ->with('success', 'Category deleted successfully.');
    }
}