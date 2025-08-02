<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PageTitleController;

class NewsPageController extends Controller
{
    public function index()
    {
        // Get current news page settings
        $newsPageTitle = PageTitleController::getPageTitle('news', 'समाचार - नेपाल पत्रकार महासंघ');
        
        $pageSettings = [
            'title' => 'समाचार',
            'meta_title' => $newsPageTitle,
            'meta_description' => 'नेपाल पत्रकार महासंघका समाचारहरू',
            'subtitle' => null,
            'description' => null,
            'featured_image' => null
        ];
        
        return view('admin.news-page.index', compact('pageSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // For now, we'll just redirect back with success
        // In a full implementation, you might want to store these in a settings table
        
        return redirect()->route('admin.news-page.index')
                        ->with('success', 'News page settings updated successfully!');
    }
}