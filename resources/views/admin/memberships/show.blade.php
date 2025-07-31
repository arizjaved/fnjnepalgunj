@extends('layouts.admin')

@section('title', 'View Member - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $membership->full_name }}</h1>
            <p class="text-gray-600">Member details</p>
        </div>
        <div class="flex space-x-2">
            @if($membership->status === 'pending')
                <form action="{{ route('admin.memberships.approve', $membership) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center" onclick="return confirm('Are you sure you want to approve this membership?')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Approve
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.memberships.edit', $membership) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.memberships.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Members
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Member Photo & Status -->
        <div class="space-y-6">
            @if($membership->photo_path)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Photo</h3>
                    <img src="{{ $membership->photo_url }}" alt="{{ $membership->full_name }}" class="w-full h-auto rounded-lg border">
                </div>
            @endif

            <!-- Status & Membership Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Membership Status</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $membership->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($membership->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($membership->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($membership->status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($membership->member_id)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Member ID</label>
                            <p class="text-sm text-gray-800 font-mono">{{ $membership->member_id }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Membership Type</label>
                        <div class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $membership->membership_type_display }}
                            </span>
                        </div>
                    </div>
                    
                    @if($membership->expires_at)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Expires At</label>
                            <p class="text-sm text-gray-800">{{ $membership->expires_at->format('M d, Y') }}</p>
                        </div>
                    @endif
                    
                    @if($membership->category)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Category</label>
                            <p class="text-sm text-gray-800">{{ $membership->category->name }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Member Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Full Name</label>
                        <p class="text-sm text-gray-800">{{ $membership->full_name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <p class="text-sm text-gray-800">{{ $membership->email }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Phone</label>
                        <p class="text-sm text-gray-800">{{ $membership->phone }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Citizenship Number</label>
                        <p class="text-sm text-gray-800">{{ $membership->citizenship_number }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Date of Birth</label>
                        <p class="text-sm text-gray-800">{{ $membership->date_of_birth->format('M d, Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Gender</label>
                        <p class="text-sm text-gray-800">{{ ucfirst($membership->gender) }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="text-sm font-medium text-gray-600">Address</label>
                    <p class="text-sm text-gray-800">{{ $membership->address }}</p>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Professional Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Education</label>
                        <p class="text-sm text-gray-800">{{ $membership->education }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Experience</label>
                        <p class="text-sm text-gray-800">{{ $membership->experience_years }} years</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Current Workplace</label>
                        <p class="text-sm text-gray-800">{{ $membership->current_workplace }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Position</label>
                        <p class="text-sm text-gray-800">{{ $membership->position }}</p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            @if($membership->citizenship_copy_path || $membership->experience_certificate_path)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Documents</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($membership->citizenship_copy_path)
                            <div>
                                <label class="text-sm font-medium text-gray-600">Citizenship Copy</label>
                                <div class="mt-1">
                                    <a href="{{ $membership->citizenship_copy_url }}" target="_blank" class="text-[#0073b7] hover:text-[#004a7f] text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View Document
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @if($membership->experience_certificate_path)
                            <div>
                                <label class="text-sm font-medium text-gray-600">Experience Certificate</label>
                                <div class="mt-1">
                                    <a href="{{ $membership->experience_certificate_url }}" target="_blank" class="text-[#0073b7] hover:text-[#004a7f] text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View Document
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Application History -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Application History</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Applied At</label>
                        <p class="text-sm text-gray-800">{{ $membership->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    @if($membership->approved_at)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Approved At</label>
                            <p class="text-sm text-gray-800">{{ $membership->approved_at->format('M d, Y') }}</p>
                        </div>
                    @endif
                    
                    @if($membership->approver)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Approved By</label>
                            <p class="text-sm text-gray-800">{{ $membership->approver->name }}</p>
                        </div>
                    @endif
                    
                    @if($membership->rejection_reason)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Rejection Reason</label>
                            <p class="text-sm text-gray-800">{{ $membership->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection