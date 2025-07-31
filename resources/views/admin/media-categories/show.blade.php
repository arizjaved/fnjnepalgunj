@extends('layouts.admin')

@section('title', 'View Category - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $mediaCategory->name }}</h1>
            <p class="text-gray-600">Category details</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.media-categories.edit', $mediaCategory) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.media-categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Details -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Category Information</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-600">Name</label>
                    <p class="text-sm text-gray-800">{{ $mediaCategory->name }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Slug</label>
                    <p class="text-sm text-gray-800 font-mono">{{ $mediaCategory->slug }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Type</label>
                    <div class="mt-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $mediaCategory->type === 'photo' ? 'bg-blue-100 text-blue-800' : 
                               ($mediaCategory->type === 'video' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($mediaCategory->type) }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Status</label>
                    <div class="mt-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $mediaCategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $mediaCategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                
                @if($mediaCategory->description)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Description</label>
                        <p class="text-sm text-gray-800">{{ $mediaCategory->description }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Created At</label>
                    <p class="text-sm text-gray-800">{{ $mediaCategory->created_at->format('M d, Y H:i') }}</p>
                </div>
                
                @if($mediaCategory->updated_at != $mediaCategory->created_at)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Updated At</label>
                        <p class="text-sm text-gray-800">{{ $mediaCategory->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Associated Media -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Photos -->
            @if($mediaCategory->type === 'photo' || $mediaCategory->type === 'both')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Photos ({{ $mediaCategory->photoGalleries->count() }})
                    </h3>
                    
                    @if($mediaCategory->photoGalleries->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($mediaCategory->photoGalleries->take(6) as $photo)
                                <div class="relative group">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->image_alt }}" class="w-full h-24 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                        <a href="{{ route('admin.photo-gallery.show', $photo) }}" class="text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 truncate">{{ $photo->title }}</p>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($mediaCategory->photoGalleries->count() > 6)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.photo-gallery.index') }}?category={{ $mediaCategory->slug }}" class="text-[#0073b7] hover:text-[#004a7f] text-sm">
                                    View all {{ $mediaCategory->photoGalleries->count() }} photos →
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-sm">No photos in this category yet.</p>
                    @endif
                </div>
            @endif

            <!-- Videos -->
            @if($mediaCategory->type === 'video' || $mediaCategory->type === 'both')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Videos ({{ $mediaCategory->videoGalleries->count() }})
                    </h3>
                    
                    @if($mediaCategory->videoGalleries->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($mediaCategory->videoGalleries->take(4) as $video)
                                <div class="relative group">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-24 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-60 transition-opacity rounded-lg flex items-center justify-center">
                                        <div class="text-white">
                                            <svg class="w-8 h-8 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                            @if($video->duration)
                                                <span class="text-xs">{{ $video->duration }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.video-gallery.show', $video) }}" class="absolute inset-0"></a>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 truncate">{{ $video->title }}</p>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($mediaCategory->videoGalleries->count() > 4)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.video-gallery.index') }}?category={{ $mediaCategory->slug }}" class="text-[#0073b7] hover:text-[#004a7f] text-sm">
                                    View all {{ $mediaCategory->videoGalleries->count() }} videos →
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-sm">No videos in this category yet.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection