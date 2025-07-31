@extends('layouts.admin')

@section('title', 'Contact Page Management - Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Contact Page Management</h1>
            <p class="text-gray-600">Manage your contact page content and information</p>
        </div>
        <a href="{{ route('admin.contact-page.edit') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Contact Page
        </a>
    </div>

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Contact Page Preview</h2>
        </div>
        
        <div class="p-6">
            <!-- Header Section -->
            @if($contactContent->banner_image)
                <div class="mb-6">
                    <img src="{{ $contactContent->banner_image_url }}" alt="Contact Banner" class="w-full h-48 object-cover rounded-lg">
                </div>
            @endif
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[#004a7f] mb-2">{{ $contactContent->title }}</h1>
                @if($contactContent->subtitle)
                    <p class="text-gray-600 text-lg">{{ $contactContent->subtitle }}</p>
                @endif
                @if($contactContent->description)
                    <p class="text-gray-600 mt-4">{{ $contactContent->description }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">सम्पर्क विवरण</h3>
                    <div class="space-y-4">
                        @if($contactContent->contact_info['address'])
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-[#0073b7] mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800">ठेगाना</h4>
                                    <p class="text-gray-600">{{ $contactContent->contact_info['address'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if($contactContent->contact_info['phone'])
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-[#0073b7] mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800">फोन</h4>
                                    <p class="text-gray-600">{{ $contactContent->contact_info['phone'] }}</p>
                                    @if($contactContent->contact_info['phone_secondary'])
                                        <p class="text-gray-600">{{ $contactContent->contact_info['phone_secondary'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($contactContent->contact_info['email'])
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-[#0073b7] mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800">इमेल</h4>
                                    <p class="text-gray-600">{{ $contactContent->contact_info['email'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">कार्यालय समय</h3>
                    <div class="space-y-2">
                        @if($contactContent->office_hours['weekdays'])
                            <p class="text-gray-600">{{ $contactContent->office_hours['weekdays'] }}</p>
                        @endif
                        @if($contactContent->office_hours['saturday'])
                            <p class="text-gray-600">{{ $contactContent->office_hours['saturday'] }}</p>
                        @endif
                        @if($contactContent->office_hours['holidays'])
                            <p class="text-gray-600">{{ $contactContent->office_hours['holidays'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            @if($contactContent->map_embed)
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">स्थान</h3>
                    <div class="rounded-lg overflow-hidden">
                        {!! $contactContent->map_embed !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Status and Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Page Status</h2>
        </div>
        
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contactContent->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($contactContent->status) }}
                    </span>
                </div>
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    @if($contactContent->updated_at)
                        <span>Last updated: {{ $contactContent->updated_at->format('M d, Y h:i A') }}</span>
                    @endif
                    @if($contactContent->updater)
                        <span>by {{ $contactContent->updater->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection