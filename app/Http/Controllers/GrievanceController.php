<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrievanceController extends Controller
{
    public function index()
    {
        return view('grievance');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically save to database
        // For now, just redirect back with success message
        
        return redirect()->back()->with('success', 'तपाईंको उजुरी सफलतापूर्वक दर्ता भएको छ।');
    }
}
