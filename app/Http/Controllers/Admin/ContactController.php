<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::query()->with('receiver')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Contact::count(),
            'pending' => Contact::pending()->count(),
            'received' => Contact::received()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load('receiver');
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,received',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $contact->status = $validated['status'];
        $contact->admin_notes = $validated['admin_notes'];

        if ($validated['status'] === 'received') {
            $contact->received_at = now();
            $contact->received_by = Auth::id();
        } else {
            $contact->received_at = null;
            $contact->received_by = null;
        }

        $contact->save();

        return redirect()->route('admin.contacts.show', $contact)
                        ->with('success', 'Contact status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Bulk update status
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
            'status' => 'required|in:pending,received',
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'received') {
            $updateData['received_at'] = now();
            $updateData['received_by'] = Auth::id();
        } else {
            $updateData['received_at'] = null;
            $updateData['received_by'] = null;
        }

        Contact::whereIn('id', $validated['contact_ids'])->update($updateData);

        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Selected contacts updated successfully.');
    }
}
