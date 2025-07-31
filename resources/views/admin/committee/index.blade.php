@extends('layouts.admin')

@section('title', 'Committee Page Management - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Committee Page Management</h1>
            <p class="text-gray-600">Manage the committee page content sections individually</p>
        </div>
        <div class="flex items-center space-x-2">
            @if($committeeContent)
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $committeeContent->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($committeeContent->status) }}
                </span>
            @endif
            <a href="{{ route('admin.committee.edit') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Full Edit
            </a>
        </div>
    </div>

    @if($committeeContent)
        <!-- Current Committee Page Content -->

            <!-- Banner Image -->
            @if($committeeContent->banner_image)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Banner Image</h3>
                    <img src="{{ $committeeContent->banner_image_url }}" alt="Banner Image" class="w-full h-64 object-cover rounded-lg border">
                </div>
            @endif

            <!-- Basic Information Section -->
                <div class="bg-white rounded-lg shadow-md p-6" id="basic-info-section">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            {{ $committeeContent->title }}
                        </h2>
                        <button onclick="editSection('basic-info')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Edit
                        </button>
                    </div>
                    
                    <div id="basic-info-display">
                        <div class="space-y-4 text-gray-700 leading-relaxed">
                            @if($committeeContent->subtitle)
                                <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] text-white p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold">{{ $committeeContent->subtitle }}</h3>
                                </div>
                            @endif
                            @if($committeeContent->description)
                                <div class="text-justify">
                                    {!! nl2br(e($committeeContent->description)) !!}
                                </div>
                            @else
                                <p class="text-gray-500 italic">No description available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div id="basic-info-edit-form" class="hidden mt-4">
                        <form onsubmit="updateSection(event, 'basic-info')">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                    <input type="text" name="title" value="{{ $committeeContent->title }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                                    <input type="text" name="subtitle" value="{{ $committeeContent->subtitle }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">{{ $committeeContent->description }}</textarea>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Update
                                </button>
                                <button type="button" onclick="cancelEdit('basic-info')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

    <!-- Term Information Section -->
                <div class="bg-white rounded-lg shadow-md p-6" id="term-info-section">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-[#004a7f] rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            समितिको जानकारी
                        </h2>
                        <button onclick="editSection('term-info')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Edit
                        </button>
                    </div>
                    
                    <div id="term-info-display">
                        @if(is_array($committeeContent->term_info) && count($committeeContent->term_info) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($committeeContent->term_info as $key => $value)
                                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="w-8 h-8 bg-[#0073b7] text-white rounded-full flex items-center justify-center mr-3 flex-shrink-0 text-sm font-bold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600 text-sm">{{ $key }}</span>
                                            <p class="text-gray-800 font-semibold">{{ $value }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">No committee information available</p>
                        @endif
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div id="term-info-edit-form" class="hidden mt-4">
                        <form onsubmit="updateSection(event, 'term-info')">
                            <div id="term-info-inputs">
                                @if(is_array($committeeContent->term_info) && count($committeeContent->term_info) > 0)
                                    @foreach($committeeContent->term_info as $key => $value)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 term-info-item">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                                                <input type="text" name="term_info_keys[]" value="{{ $key }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., कार्यकाल">
                                            </div>
                                            <div class="flex items-end space-x-2">
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                                                    <input type="text" name="term_info_values[]" value="{{ $value }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., २०८१-२०८३ (३ वर्ष)">
                                                </div>
                                                <button type="button" onclick="removeTermInfo(this)" class="text-red-600 hover:text-red-800 px-2 py-2 mb-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 term-info-item">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                                            <input type="text" name="term_info_keys[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., कार्यकाल">
                                        </div>
                                        <div class="flex items-end space-x-2">
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                                                <input type="text" name="term_info_values[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., २०८१-२०८३ (३ वर्ष)">
                                            </div>
                                            <button type="button" onclick="removeTermInfo(this)" class="text-red-600 hover:text-red-800 px-2 py-2 mb-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addTermInfo()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Term Info</button>
                            <div class="flex space-x-2 mt-4">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Update
                                </button>
                                <button type="button" onclick="cancelEdit('term-info')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

    <!-- Responsibilities Section -->
                <div class="bg-white rounded-lg shadow-md p-6" id="responsibilities-section">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            मुख्य जिम्मेवारीहरू
                        </h2>
                        <button onclick="editSection('responsibilities')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Edit
                        </button>
                    </div>
                    
                    <div id="responsibilities-display">
                        @if(is_array($committeeContent->responsibilities) && count($committeeContent->responsibilities) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($committeeContent->responsibilities as $index => $responsibility)
                                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="w-8 h-8 bg-[#0073b7] text-white rounded-full flex items-center justify-center mr-3 flex-shrink-0 text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <span class="text-gray-700">{{ $responsibility }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">No responsibilities available</p>
                        @endif
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div id="responsibilities-edit-form" class="hidden mt-4">
                        <form onsubmit="updateSection(event, 'responsibilities')">
                            <div id="responsibilities-inputs">
                                @if(is_array($committeeContent->responsibilities) && count($committeeContent->responsibilities) > 0)
                                    @foreach($committeeContent->responsibilities as $responsibility)
                                        <div class="mb-2 responsibility-item">
                                            <div class="flex items-center space-x-2">
                                                <input type="text" name="responsibilities[]" value="{{ $responsibility }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                                                <button type="button" onclick="removeResponsibility(this)" class="text-red-600 hover:text-red-800 px-2 py-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="mb-2 responsibility-item">
                                        <div class="flex items-center space-x-2">
                                            <input type="text" name="responsibilities[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Responsibility 1">
                                            <button type="button" onclick="removeResponsibility(this)" class="text-red-600 hover:text-red-800 px-2 py-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addResponsibility()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Responsibility</button>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Update
                                </button>
                                <button type="button" onclick="cancelEdit('responsibilities')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

    <!-- Contact Information Section -->
                <div class="bg-white rounded-lg shadow-md p-6" id="contact-info-section">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            सम्पर्क जानकारी
                        </h2>
                        <button onclick="editSection('contact-info')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Edit
                        </button>
                    </div>
                    
                    <div id="contact-info-display">
                        @if(is_array($committeeContent->contact_info) && count(array_filter($committeeContent->contact_info)) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($committeeContent->contact_info['address'])
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $committeeContent->contact_info['address'] }}</span>
                                    </div>
                                @endif
                                @if($committeeContent->contact_info['phone'])
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $committeeContent->contact_info['phone'] }}</span>
                                    </div>
                                @endif
                                @if($committeeContent->contact_info['email'])
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $committeeContent->contact_info['email'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 italic">No contact information available</p>
                        @endif
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div id="contact-info-edit-form" class="hidden mt-4">
                        <form onsubmit="updateSection(event, 'contact-info')">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" name="contact_address" value="{{ $committeeContent->contact_info['address'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., काठमाडौं, नेपाल">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" name="contact_phone" value="{{ $committeeContent->contact_info['phone'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., +977-1-4444444">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="contact_email" value="{{ $committeeContent->contact_info['email'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., info@fnjnepal.org">
                                </div>
                            </div>
                            <div class="flex space-x-2 mt-4">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Update
                                </button>
                                <button type="button" onclick="cancelEdit('contact-info')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    @else
        <!-- No Committee Page Content -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Committee Page Content</h3>
            <p class="text-gray-600 mb-4">Create your committee page content to get started.</p>
            <a href="{{ route('admin.committee.edit') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg transition-colors inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Committee Page
            </a>
        </div>
    @endif
</div>
@endsection
<script>
function editSection(section) {
    // Hide display and show edit form
    const displayElement = document.getElementById(section + '-display');
    const editForm = document.getElementById(section + '-edit-form');
    
    if (displayElement) displayElement.style.display = 'none';
    if (editForm) editForm.classList.remove('hidden');
}

function cancelEdit(section) {
    // Show display and hide edit form
    const displayElement = document.getElementById(section + '-display');
    const editForm = document.getElementById(section + '-edit-form');
    
    if (displayElement) displayElement.style.display = 'block';
    if (editForm) editForm.classList.add('hidden');
}

function updateSection(event, section) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('section', section);
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    fetch('{{ route("admin.committee.update-section") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Section updated successfully!', 'success');
            // Reload to show updated content
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Error updating section: ' + data.message, 'error');
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating section', 'error');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function addResponsibility() {
    const container = document.getElementById('responsibilities-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 responsibility-item';
    div.innerHTML = `
        <div class="flex items-center space-x-2">
            <input type="text" name="responsibilities[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Responsibility ${count}">
            <button type="button" onclick="removeResponsibility(this)" class="text-red-600 hover:text-red-800 px-2 py-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeResponsibility(button) {
    const container = document.getElementById('responsibilities-inputs');
    if (container.children.length > 1) {
        button.closest('.responsibility-item').remove();
    }
}

function addTermInfo() {
    const container = document.getElementById('term-info-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 term-info-item';
    div.innerHTML = `
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
            <input type="text" name="term_info_keys[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., कार्यकाल">
        </div>
        <div class="flex items-end space-x-2">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                <input type="text" name="term_info_values[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="e.g., २०८१-२०८३ (३ वर्ष)">
            </div>
            <button type="button" onclick="removeTermInfo(this)" class="text-red-600 hover:text-red-800 px-2 py-2 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeTermInfo(button) {
    const container = document.getElementById('term-info-inputs');
    if (container.children.length > 1) {
        button.closest('.term-info-item').remove();
    }
}
</script>