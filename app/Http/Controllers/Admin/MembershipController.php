<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $query = Membership::with(['category', 'approver']);
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $memberships = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get counts for different statuses
        $statusCounts = [
            'all' => Membership::count(),
            'pending' => Membership::where('status', 'pending')->count(),
            'approved' => Membership::where('status', 'approved')->count(),
            'rejected' => Membership::where('status', 'rejected')->count(),
            'expired' => Membership::where('status', 'expired')->count(),
        ];
        
        return view('admin.memberships.index', compact('memberships', 'statusCounts'));
    }

    public function create()
    {
        $categories = \App\Models\MembershipCategory::active()->ordered()->get();
        return view('admin.memberships.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:memberships,email',
            'phone' => 'required|string|max:20',
            'citizenship_number' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'education' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'current_workplace' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'membership_type' => 'required|in:associate,regular,life',
            'status' => 'required|in:pending,approved,rejected',
            'category_id' => 'nullable|exists:membership_categories,id',
            'is_executive_committee' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'citizenship_copy' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'experience_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['photo', 'citizenship_copy', 'experience_certificate']);
        
        // Handle checkbox for executive committee
        $data['is_executive_committee'] = $request->has('is_executive_committee') ? true : false;
        
        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('memberships/photos', 'public');
        }
        
        if ($request->hasFile('citizenship_copy')) {
            $data['citizenship_copy_path'] = $request->file('citizenship_copy')->store('memberships/citizenship', 'public');
        }
        
        if ($request->hasFile('experience_certificate')) {
            $data['experience_certificate_path'] = $request->file('experience_certificate')->store('memberships/certificates', 'public');
        }

        if ($request->status === 'approved') {
            $data['approved_by'] = auth()->id();
        }

        Membership::create($data);

        return redirect()->route('admin.memberships.index')
                        ->with('success', 'Membership created successfully.');
    }

    public function show(Membership $membership)
    {
        $membership->load(['category', 'approver']);
        return view('admin.memberships.show', compact('membership'));
    }

    public function edit(Membership $membership)
    {
        $categories = \App\Models\MembershipCategory::active()->ordered()->get();
        return view('admin.memberships.edit', compact('membership', 'categories'));
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:memberships,email,' . $membership->id,
            'phone' => 'required|string|max:20',
            'citizenship_number' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'education' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'current_workplace' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'membership_type' => 'required|in:associate,regular,life',
            'status' => 'required|in:pending,approved,rejected,inactive,expired',
            'category_id' => 'nullable|exists:membership_categories,id',
            'is_executive_committee' => 'nullable|boolean',
            'rejection_reason' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'citizenship_copy' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'experience_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['photo', 'citizenship_copy', 'experience_certificate']);
        
        // Handle checkbox for executive committee
        $data['is_executive_committee'] = $request->has('is_executive_committee') ? true : false;
        
        // Handle status change to approved
        if ($request->status === 'approved' && $membership->status !== 'approved') {
            $data['approved_by'] = auth()->id();
        }
        
        // Handle file uploads
        if ($request->hasFile('photo')) {
            if ($membership->photo_path) {
                Storage::disk('public')->delete($membership->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('memberships/photos', 'public');
        }
        
        if ($request->hasFile('citizenship_copy')) {
            if ($membership->citizenship_copy_path) {
                Storage::disk('public')->delete($membership->citizenship_copy_path);
            }
            $data['citizenship_copy_path'] = $request->file('citizenship_copy')->store('memberships/citizenship', 'public');
        }
        
        if ($request->hasFile('experience_certificate')) {
            if ($membership->experience_certificate_path) {
                Storage::disk('public')->delete($membership->experience_certificate_path);
            }
            $data['experience_certificate_path'] = $request->file('experience_certificate')->store('memberships/certificates', 'public');
        }

        $membership->update($data);

        return redirect()->route('admin.memberships.index')
                        ->with('success', 'Membership updated successfully.');
    }

    public function destroy(Membership $membership)
    {
        // Delete associated files
        if ($membership->photo_path) {
            Storage::disk('public')->delete($membership->photo_path);
        }
        if ($membership->citizenship_copy_path) {
            Storage::disk('public')->delete($membership->citizenship_copy_path);
        }
        if ($membership->experience_certificate_path) {
            Storage::disk('public')->delete($membership->experience_certificate_path);
        }

        $membership->delete();

        return redirect()->route('admin.memberships.index')
                        ->with('success', 'Membership deleted successfully.');
    }

    public function approve(Membership $membership)
    {
        $membership->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()
                        ->with('success', 'Membership approved successfully.');
    }

    public function reject(Request $request, Membership $membership)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $membership->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()
                        ->with('success', 'Membership rejected.');
    }
}