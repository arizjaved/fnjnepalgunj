<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('membership');
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
            'terms' => 'required|accepted',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'citizenship_copy' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'experience_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['photo', 'citizenship_copy', 'experience_certificate', 'terms']);
        $data['status'] = 'pending';
        
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

        \App\Models\Membership::create($data);

        return redirect()->route('membership.index')->with('success', 'तपाईंको सदस्यता आवेदन सफलतापूर्वक पेश गरिएको छ। समीक्षा पछि तपाईंलाई सम्पर्क गरिनेछ।');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string',
        ]);

        $status = \App\Models\Membership::checkMembershipStatus($request->member_id);

        return response()->json($status);
    }
}