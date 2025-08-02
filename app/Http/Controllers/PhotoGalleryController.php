<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoGallery;
use App\Models\MediaCategory;
use App\Http\Controllers\Admin\PageTitleController;

class PhotoGalleryController extends Controller
{
    public function index(Request $request)
    {
        // Create page content object with default values
        $pageContent = (object) [
            'title' => 'फोटो ग्यालरी',
            'subtitle' => null,
            'description' => null,
            'featured_image' => null,
            'meta_title' => PageTitleController::getPageTitle('photo_gallery', 'फोटो ग्यालरी - नेपाल पत्रकार महासंघ'),
            'meta_description' => 'नेपाल पत्रकार महासंघको फोटो ग्यालरी'
        ];
        
        $query = PhotoGallery::active()->with('category')->ordered();
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $photos = $query->paginate(12);
        $categories = MediaCategory::active()->forPhotos()->withCount('photoGalleries')->orderBy('name')->get();
        
        return view('photo-gallery', compact('photos', 'categories', 'pageContent'));
    }
}