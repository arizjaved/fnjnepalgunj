<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = News::with(['creator', 'updater', 'category']);
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhereHas('creator', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $news = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $news->appends($request->query());
        
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = \App\Models\NewsCategory::active()->ordered()->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        // Always set published_at to current time
        $validated['published_at'] = now();

        News::create($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News article created successfully.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = \App\Models\NewsCategory::active()->ordered()->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        // Log the request method to debug
        \Log::info('Update method called', [
            'method' => $request->method(),
            'route' => $request->route()->getName(),
            'news_id' => $news->id
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:news_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_featured'] = $request->has('is_featured');

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        // Update slug if title changed
        if ($validated['title'] !== $news->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Only update published_at if it's not already set or if status changed to published
        if (!$news->published_at || ($validated['status'] === 'published' && $news->status !== 'published')) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        \Log::info('News article updated successfully', ['news_id' => $news->id]);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        // Log the destroy method call to debug
        \Log::info('Destroy method called', [
            'method' => request()->method(),
            'route' => request()->route()->getName(),
            'news_id' => $news->id
        ]);

        // Delete associated image
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        \Log::info('News article deleted successfully', ['news_id' => $news->id]);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News article deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'selected_articles' => 'required|array|min:1',
            'selected_articles.*' => 'exists:news,id'
        ]);

        $action = $validated['action'];
        $articleIds = $validated['selected_articles'];
        $articles = News::whereIn('id', $articleIds)->get();

        $count = $articles->count();
        $successMessage = '';

        switch ($action) {
            case 'publish':
                $articles->each(function ($article) {
                    $article->update([
                        'status' => 'published',
                        'published_at' => now(),
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} article(s) published successfully.";
                break;

            case 'draft':
                $articles->each(function ($article) {
                    $article->update([
                        'status' => 'draft',
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} article(s) moved to draft successfully.";
                break;

            case 'delete':
                $articles->each(function ($article) {
                    // Delete associated image
                    if ($article->featured_image) {
                        Storage::disk('public')->delete($article->featured_image);
                    }
                    $article->delete();
                });
                $successMessage = "{$count} article(s) deleted successfully.";
                break;
        }

        return redirect()->route('admin.news.index')
                        ->with('success', $successMessage);
    }
}
