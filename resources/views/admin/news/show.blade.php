@extends('layouts.admin')

@section('title', 'View News Article')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">View News Article</h1>
            <p class="text-gray-600">Review and manage your news article</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.news.edit', $news) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Article
            </a>
            <a href="{{ route('admin.news.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to News
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Article Content (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                @if($news->featured_image)
                    <div class="mb-6">
                        <img src="{{ $news->featured_image_url }}" 
                             class="w-full h-64 object-cover rounded-lg" 
                             alt="{{ $news->title }}">
                    </div>
                @endif
                
                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                
                @if($news->excerpt)
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">{{ $news->excerpt }}</p>
                @endif
                
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    @if($news->status === 'published')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Published
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Draft
                        </span>
                    @endif
                    
                    @if($news->published_at)
                        <div class="flex items-center text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $news->published_at->format('F d, Y') }}
                        </div>
                    @endif
                    
                    <div class="flex items-center text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $news->creator->name }}
                    </div>
                </div>
                
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $news->content }}</div>
                </div>
            </div>
        </div>

        <!-- Sidebar (1/3 width) -->
        <div class="space-y-6">
            <!-- Article Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Article Information</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Status</span>
                        @if($news->status === 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Draft
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Created</span>
                        <span class="text-sm text-gray-900">{{ $news->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Created by</span>
                        <span class="text-sm text-gray-900">{{ $news->creator->name }}</span>
                    </div>
                    
                    @if($news->published_at)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Published</span>
                            <span class="text-sm text-gray-900">{{ $news->published_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    
                    @if($news->updated_at != $news->created_at)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Last updated</span>
                            <span class="text-sm text-gray-900">{{ $news->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    
                    @if($news->updater)
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Updated by</span>
                            <span class="text-sm text-gray-900">{{ $news->updater->name }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium text-gray-500">Slug</span>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-800">{{ $news->slug }}</code>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.news.edit', $news) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Article
                    </a>
                    
                    @if($news->status === 'published')
                        <a href="{{ route('news.show', $news->slug) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200" 
                           target="_blank">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View on Website
                        </a>
                    @endif
                    
                    <form action="{{ route('admin.news.destroy', $news) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')"
                          class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>

            @if($news->featured_image)
                <!-- Featured Image Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h3>
                    <div class="text-center">
                        <img src="{{ $news->featured_image_url }}" 
                             class="w-full rounded-lg" 
                             alt="{{ $news->title }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection