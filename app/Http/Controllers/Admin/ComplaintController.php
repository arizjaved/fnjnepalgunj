<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
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
        $query = Complaint::query()->with('resolver')->latest();

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

        $complaints = $query->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Complaint::count(),
            'pending' => Complaint::pending()->count(),
            'in_process' => Complaint::inProcess()->count(),
            'resolved' => Complaint::resolved()->count(),
            'rejected' => Complaint::rejected()->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load('resolver');
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_process,resolved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $complaint->status = $validated['status'];
        $complaint->admin_notes = $validated['admin_notes'];

        if (in_array($validated['status'], ['resolved', 'rejected'])) {
            $complaint->resolved_at = now();
            $complaint->resolved_by = Auth::id();
        } else {
            $complaint->resolved_at = null;
            $complaint->resolved_by = null;
        }

        $complaint->save();

        return redirect()->route('admin.complaints.show', $complaint)
                        ->with('success', 'Complaint status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('admin.complaints.index')
                        ->with('success', 'Complaint deleted successfully.');
    }

    /**
     * Bulk update status
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'complaint_ids' => 'required|array',
            'complaint_ids.*' => 'exists:complaints,id',
            'status' => 'required|in:pending,in_process,resolved,rejected',
        ]);

        $updateData = ['status' => $validated['status']];

        if (in_array($validated['status'], ['resolved', 'rejected'])) {
            $updateData['resolved_at'] = now();
            $updateData['resolved_by'] = Auth::id();
        } else {
            $updateData['resolved_at'] = null;
            $updateData['resolved_by'] = null;
        }

        Complaint::whereIn('id', $validated['complaint_ids'])->update($updateData);

        return redirect()->route('admin.complaints.index')
                        ->with('success', 'Selected complaints updated successfully.');
    }
}
