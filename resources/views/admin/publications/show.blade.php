@extends('layouts.admin')

@section('title', 'View Content - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $publication->title }}</h1>
            <p class="text-gray-600">{{ $publication->type_display }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.publications.edit', $publication) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.publications.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Content Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Title</dt>
                            <dd class="text-sm text-gray-900">{{ $publication->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="text-sm">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $publication->type === 'publication' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $publication->type_display }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $publication->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($publication->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="text-sm text-gray-900">{{ $publication->created_at->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        @if($publication->published_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Published</dt>
                                <dd class="text-sm text-gray-900">{{ $publication->published_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                        @endif
                        @if($publication->updated_at && $publication->updated_at != $publication->created_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $publication->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Document Information -->
            @if($publication->document_file)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Document</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">{{ $publication->document_name }}</h4>
                                <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                    <span>{{ $publication->document_size_formatted }}</span>
                                    <span>{{ strtoupper($publication->document_type) }}</span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.publications.download', $publication) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download
                                </a>
                                <a href="{{ $publication->document_url }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-[#004a7f] hover:bg-[#003366] text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Document</h3>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500">No document uploaded</p>
                    </div>
                </div>
            @endif

            <!-- User Information -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($publication->creator)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created by</dt>
                            <dd class="text-sm text-gray-900">{{ $publication->creator->name }}</dd>
                        </div>
                    @endif
                    @if($publication->updater)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last updated by</dt>
                            <dd class="text-sm text-gray-900">{{ $publication->updater->name }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center justify-between">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.publications.edit', $publication) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Content
                        </a>
                        @if($publication->status === 'published')
                            @if($publication->type === 'publication')
                                <a href="{{ route('publications') }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View on Frontend
                                </a>
                            @else
                                <a href="{{ route('economic-activity') }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View on Frontend
                                </a>
                            @endif
                        @endif
                    </div>
                    <form action="{{ route('admin.publications.destroy', $publication) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Content
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection