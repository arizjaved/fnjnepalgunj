<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = NewsCategory::with(['creator', 'updater'])
                            ->withCount('news');
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $categories = $query->ordered()->paginate(10);
        
        // Preserve query parameters in pagination links
        $categories->appends($request->query());
        
        return view('admin.news-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.news-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        NewsCategory::create($validated);

        return redirect()->route('admin.news-categories.index')
                        ->with('success', 'News category created successfully.');
    }

    public function show(NewsCategory $newsCategory)
    {
        $newsCategory->load(['creator', 'updater', 'news' => function($query) {
            $query->with('creator')->latest()->take(10);
        }]);
        
        return view('admin.news-categories.show', compact('newsCategory'));
    }

    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news-categories.edit', compact('newsCategory'));
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Update slug if name changed
        if ($validated['name'] !== $newsCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $newsCategory->update($validated);

        return redirect()->route('admin.news-categories.index')
                        ->with('success', 'News category updated successfully.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        // Check if category has news articles
        if ($newsCategory->news()->count() > 0) {
            return redirect()->route('admin.news-categories.index')
                            ->with('error', 'Cannot delete category that has news articles. Please reassign or delete the articles first.');
        }

        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
                        ->with('success', 'News category deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_categories' => 'required|array|min:1',
            'selected_categories.*' => 'exists:news_categories,id'
        ]);

        $action = $validated['action'];
        $categoryIds = $validated['selected_categories'];
        $categories = NewsCategory::whereIn('id', $categoryIds)->get();

        $count = $categories->count();
        $successMessage = '';

        switch ($action) {
            case 'activate':
                $categories->each(function ($category) {
                    $category->update([
                        'is_active' => true,
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} category(ies) activated successfully.";
                break;

            case 'deactivate':
                $categories->each(function ($category) {
                    $category->update([
                        'is_active' => false,
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} category(ies) deactivated successfully.";
                break;

            case 'delete':
                $categoriesWithNews = $categories->filter(function ($category) {
                    return $category->news()->count() > 0;
                });

                if ($categoriesWithNews->count() > 0) {
                    return redirect()->route('admin.news-categories.index')
                                    ->with('error', 'Cannot delete categories that have news articles. Please reassign or delete the articles first.');
                }

                $categories->each(function ($category) {
                    $category->delete();
                });
                $successMessage = "{$count} category(ies) deleted successfully.";
                break;
        }

        return redirect()->route('admin.news-categories.index')
                        ->with('success', $successMessage);
    }
}