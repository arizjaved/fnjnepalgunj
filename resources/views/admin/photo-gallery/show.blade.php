@extends('layouts.admin')

@section('title', 'View Photo - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $photoGallery->title }}</h1>
            <p class="text-gray-600">Photo details</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.photo-gallery.edit', $photoGallery) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.photo-gallery.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Gallery
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Photo Display -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-4">
                    <img src="{{ $photoGallery->image_url }}" alt="{{ $photoGallery->image_alt }}" class="w-full h-auto rounded-lg border">
                </div>
                
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $photoGallery->title }}</h2>
                
                @if($photoGallery->description)
                    <p class="text-gray-600 mb-4">{{ $photoGallery->description }}</p>
                @endif
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $photoGallery->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Photo Details -->
        <div class="space-y-6">
            <!-- Status & Category -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Photo Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $photoGallery->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($photoGallery->status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($photoGallery->category)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Category</label>
                            <div class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $photoGallery->category->name }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Sort Order</label>
                        <p class="text-sm text-gray-800">{{ $photoGallery->sort_order }}</p>
                    </div>
                    
                    @if($photoGallery->image_alt)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Alt Text</label>
                            <p class="text-sm text-gray-800">{{ $photoGallery->image_alt }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Creator Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Creator Information</h3>
                
                <div class="space-y-3">
                    @if($photoGallery->creator)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Created By</label>
                            <p class="text-sm text-gray-800">{{ $photoGallery->creator->name }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Created At</label>
                        <p class="text-sm text-gray-800">{{ $photoGallery->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    @if($photoGallery->updater)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Last Updated By</label>
                            <p class="text-sm text-gray-800">{{ $photoGallery->updater->name }}</p>
                        </div>
                    @endif
                    
                    @if($photoGallery->updated_at != $photoGallery->created_at)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Updated At</label>
                            <p class="text-sm text-gray-800">{{ $photoGallery->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection