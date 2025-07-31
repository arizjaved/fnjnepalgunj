<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Publication::with(['creator', 'updater']);
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('document_name', 'like', "%{$searchTerm}%")
                  ->orWhereHas('creator', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }
        
        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $publications = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $publications->appends($request->query());
        
        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:publication,economic_activity',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $validated['created_by'] = Auth::id();

        // Handle document upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $validated['document_file'] = $file->store('publications', 'public');
            $validated['document_name'] = $file->getClientOriginalName();
            $validated['document_type'] = $file->getClientOriginalExtension();
            $validated['document_size'] = $file->getSize();
        }

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove the document field from validated data as it's not in the fillable array
        unset($validated['document']);

        Publication::create($validated);

        return redirect()->route('admin.publications.index')
                        ->with('success', 'Content created successfully.');
    }

    public function show(Publication $publication)
    {
        return view('admin.publications.show', compact('publication'));
    }

    public function edit(Publication $publication)
    {
        return view('admin.publications.edit', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:publication,economic_activity',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $validated['updated_by'] = Auth::id();

        // Handle document upload
        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($publication->document_file) {
                Storage::disk('public')->delete($publication->document_file);
            }
            
            $file = $request->file('document');
            $validated['document_file'] = $file->store('publications', 'public');
            $validated['document_name'] = $file->getClientOriginalName();
            $validated['document_type'] = $file->getClientOriginalExtension();
            $validated['document_size'] = $file->getSize();
        }

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove the document field from validated data as it's not in the fillable array
        unset($validated['document']);

        $publication->update($validated);

        return redirect()->route('admin.publications.index')
                        ->with('success', 'Content updated successfully.');
    }

    public function destroy(Publication $publication)
    {
        // Delete associated document file
        if ($publication->document_file) {
            Storage::disk('public')->delete($publication->document_file);
        }

        $publication->delete();

        return redirect()->route('admin.publications.index')
                        ->with('success', 'Content deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:publications,id'
        ]);

        $action = $validated['action'];
        $itemIds = $validated['selected_items'];
        $items = Publication::whereIn('id', $itemIds)->get();

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
                $successMessage = "{$count} item(s) published successfully.";
                break;

            case 'draft':
                $items->each(function ($item) {
                    $item->update([
                        'status' => 'draft',
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} item(s) moved to draft successfully.";
                break;

            case 'delete':
                $items->each(function ($item) {
                    // Delete associated document file
                    if ($item->document_file) {
                        Storage::disk('public')->delete($item->document_file);
                    }
                    $item->delete();
                });
                $successMessage = "{$count} item(s) deleted successfully.";
                break;
        }

        return redirect()->route('admin.publications.index')
                        ->with('success', $successMessage);
    }

    public function download(Publication $publication)
    {
        if (!$publication->document_file || !Storage::disk('public')->exists($publication->document_file)) {
            abort(404, 'Document not found.');
        }

        return Storage::disk('public')->download(
            $publication->document_file,
            $publication->document_name ?: 'document.' . $publication->document_type
        );
    }
}
