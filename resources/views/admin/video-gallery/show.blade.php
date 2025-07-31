@extends('layouts.admin')

@section('title', 'View Video - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $videoGallery->title }}</h1>
            <p class="text-gray-600">Video details</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.video-gallery.edit', $videoGallery) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.video-gallery.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Gallery
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Video Player -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="aspect-video mb-4">
                    <iframe class="w-full h-full rounded-lg" src="{{ $videoGallery->embed_url }}" frameborder="0" allowfullscreen></iframe>
                </div>
                
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $videoGallery->title }}</h2>
                
                @if($videoGallery->description)
                    <p class="text-gray-600 mb-4">{{ $videoGallery->description }}</p>
                @endif
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $videoGallery->created_at->format('M d, Y') }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ $videoGallery->views }} views
                    </span>
                    @if($videoGallery->duration)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $videoGallery->duration }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Video Details -->
        <div class="space-y-6">
            <!-- Status & Category -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Video Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $videoGallery->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($videoGallery->status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($videoGallery->category)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Category</label>
                            <div class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $videoGallery->category->name }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Sort Order</label>
                        <p class="text-sm text-gray-800">{{ $videoGallery->sort_order }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">YouTube Video ID</label>
                        <p class="text-sm text-gray-800 font-mono">{{ $videoGallery->youtube_video_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Creator Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Creator Information</h3>
                
                <div class="space-y-3">
                    @if($videoGallery->creator)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Created By</label>
                            <p class="text-sm text-gray-800">{{ $videoGallery->creator->name }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Created At</label>
                        <p class="text-sm text-gray-800">{{ $videoGallery->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    @if($videoGallery->updater)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Last Updated By</label>
                            <p class="text-sm text-gray-800">{{ $videoGallery->updater->name }}</p>
                        </div>
                    @endif
                    
                    @if($videoGallery->updated_at != $videoGallery->created_at)
                        <div>
                            <label class="text-sm font-medium text-gray-600">Updated At</label>
                            <p class="text-sm text-gray-800">{{ $videoGallery->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.aspect-video {
    aspect-ratio: 16 / 9;
}
</style>
@endsection