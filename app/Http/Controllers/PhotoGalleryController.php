<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoGallery;
use App\Models\MediaCategory;

class PhotoGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = PhotoGallery::active()->with('category')->ordered();
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $photos = $query->paginate(12);
        $categories = MediaCategory::active()->forPhotos()->withCount('photoGalleries')->orderBy('name')->get();
        
        return view('photo-gallery', compact('photos', 'categories'));
    }
}
