<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PressReleaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = PressRelease::with(['creator', 'updater']);
        
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
        
        $pressReleases = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $pressReleases->appends($request->query());
        
        return view('admin.press-releases.index', compact('pressReleases'));
    }

    public function create()
    {
        return view('admin.press-releases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,txt,rtf|max:5120',
            'status' => 'required|in:draft,published',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        // Handle document upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $validated['document_file'] = $file->store('press-releases/documents', 'public');
            $validated['document_name'] = $file->getClientOriginalName();
            $validated['document_type'] = $file->getClientOriginalExtension();
            $validated['document_size'] = $file->getSize();
        }

        // Always set published_at to current time
        $validated['published_at'] = now();

        PressRelease::create($validated);

        return redirect()->route('admin.press-releases.index')
                        ->with('success', 'Press release created successfully.');
    }

    public function show(PressRelease $pressRelease)
    {
        return view('admin.press-releases.show', compact('pressRelease'));
    }

    public function edit(PressRelease $pressRelease)
    {
        return view('admin.press-releases.edit', compact('pressRelease'));
    }

    public function update(Request $request, PressRelease $pressRelease)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,txt,rtf|max:5120',
            'status' => 'required|in:draft,published',
        ]);

        $validated['updated_by'] = Auth::id();

        // Handle document upload
        if ($request->hasFile('document_file')) {
            // Delete old document if exists
            if ($pressRelease->document_file) {
                Storage::disk('public')->delete($pressRelease->document_file);
            }
            $file = $request->file('document_file');
            $validated['document_file'] = $file->store('press-releases/documents', 'public');
            $validated['document_name'] = $file->getClientOriginalName();
            $validated['document_type'] = $file->getClientOriginalExtension();
            $validated['document_size'] = $file->getSize();
        }

        // Update slug if title changed
        if ($validated['title'] !== $pressRelease->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Only update published_at if it's not already set or if status changed to published
        if (!$pressRelease->published_at || ($validated['status'] === 'published' && $pressRelease->status !== 'published')) {
            $validated['published_at'] = now();
        }

        $pressRelease->update($validated);

        return redirect()->route('admin.press-releases.index')
                        ->with('success', 'Press release updated successfully.');
    }

    public function destroy(PressRelease $pressRelease)
    {
        // Delete associated document
        if ($pressRelease->document_file) {
            Storage::disk('public')->delete($pressRelease->document_file);
        }

        $pressRelease->delete();

        return redirect()->route('admin.press-releases.index')
                        ->with('success', 'Press release deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:press_releases,id'
        ]);

        $action = $validated['action'];
        $itemIds = $validated['selected_items'];
        $items = PressRelease::whereIn('id', $itemIds)->get();

        $count = $items->count();
        $successMessage = '';

        switch ($action) {
            case 'publish':
                $items->each(function ($item) {
                    $item->update([
                        'status' => 'published',
                        'published_at' => $item->published_at ?: now(),
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} press release(s) published successfully.";
                break;

            case 'draft':
                $items->each(function ($item) {
                    $item->update([
                        'status' => 'draft',
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} press release(s) moved to draft successfully.";
                break;

            case 'delete':
                $items->each(function ($item) {
                    // Delete associated document
                    if ($item->document_file) {
                        Storage::disk('public')->delete($item->document_file);
                    }
                    $item->delete();
                });
                $successMessage = "{$count} press release(s) deleted successfully.";
                break;
        }

        return redirect()->route('admin.press-releases.index')
                        ->with('success', $successMessage);
    }

    public function download(PressRelease $pressRelease)
    {
        if (!$pressRelease->document_file || !Storage::disk('public')->exists($pressRelease->document_file)) {
            abort(404, 'Document not found.');
        }

        return Storage::disk('public')->download(
            $pressRelease->document_file,
            $pressRelease->document_name ?: 'press-release-document.' . $pressRelease->document_type
        );
    }
}
