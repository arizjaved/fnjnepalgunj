<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Notice::with(['creator', 'updater']);
        
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
        
        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'expired') {
                $query->published()->where('valid_until', '<', now()->toDateString());
            } else {
                $query->where('status', $request->status);
            }
        }
        
        $notices = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $notices->appends($request->query());
        
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max - required for notices
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:today',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        // Handle document upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $validated['document_file'] = $file->store('notices', 'public');
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

        Notice::create($validated);

        return redirect()->route('admin.notices.index')
                        ->with('success', 'Notice created successfully.');
    }

    public function show(Notice $notice)
    {
        return view('admin.notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:today',
        ]);

        $validated['updated_by'] = Auth::id();

        // Handle document upload
        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($notice->document_file) {
                Storage::disk('public')->delete($notice->document_file);
            }
            
            $file = $request->file('document');
            $validated['document_file'] = $file->store('notices', 'public');
            $validated['document_name'] = $file->getClientOriginalName();
            $validated['document_type'] = $file->getClientOriginalExtension();
            $validated['document_size'] = $file->getSize();
        }

        // Update slug if title changed
        if ($validated['title'] !== $notice->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove the document field from validated data as it's not in the fillable array
        unset($validated['document']);

        $notice->update($validated);

        return redirect()->route('admin.notices.index')
                        ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        // Delete associated document file
        if ($notice->document_file) {
            Storage::disk('public')->delete($notice->document_file);
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')
                        ->with('success', 'Notice deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:notices,id'
        ]);

        $action = $validated['action'];
        $itemIds = $validated['selected_items'];
        $items = Notice::whereIn('id', $itemIds)->get();

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
                $successMessage = "{$count} notice(s) published successfully.";
                break;

            case 'draft':
                $items->each(function ($item) {
                    $item->update([
                        'status' => 'draft',
                        'updated_by' => Auth::id()
                    ]);
                });
                $successMessage = "{$count} notice(s) moved to draft successfully.";
                break;

            case 'delete':
                $items->each(function ($item) {
                    // Delete associated document file
                    if ($item->document_file) {
                        Storage::disk('public')->delete($item->document_file);
                    }
                    $item->delete();
                });
                $successMessage = "{$count} notice(s) deleted successfully.";
                break;
        }

        return redirect()->route('admin.notices.index')
                        ->with('success', $successMessage);
    }
}
