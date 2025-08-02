@extends('layouts.admin')

@section('title', 'Page Titles Management - Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Enhanced Page Header -->
    <div class="bg-gradient-to-r from-[#0073b7] via-[#004a7f] to-[#003366] rounded-xl p-8 text-white mb-8 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="relative flex items-center justify-between">
            <div>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Page Titles Management</h1>
                        <p class="text-white/80 text-lg">Edit page titles for frontend pages</p>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-white/70">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-white">Page Titles</span>
                </nav>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.page-titles.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Frontend Page Titles
                </h2>
                <p class="text-sm text-gray-600 mt-1">Edit the titles that appear on frontend pages (excluding Committee and About pages)</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @foreach($pageTitles as $key => $pageTitle)
                        <div class="space-y-2">
                            <label for="title_{{ $key }}" class="block text-sm font-medium text-gray-700">
                                {{ $pageTitle['label'] }}
                                <span class="text-xs text-gray-500 block font-normal">{{ $pageTitle['description'] }}</span>
                            </label>
                            <input type="text" 
                                   id="title_{{ $key }}" 
                                   name="titles[{{ $key }}]" 
                                   value="{{ old('titles.' . $key, $pageTitle['current']) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('titles.' . $key) border-red-500 @enderror"
                                   placeholder="Enter page title">
                            @error('titles.' . $key)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Information Box -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800">Note</h3>
                            <p class="text-sm text-blue-700 mt-1">
                                Committee and About page titles are managed separately through their respective content management sections. 
                                These titles will appear in the browser tab and search engine results.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-8">
            <button type="submit" 
                    class="px-8 py-3 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Page Titles
            </button>
        </div>
    </form>
</div>
@endsection