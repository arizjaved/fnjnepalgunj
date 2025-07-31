@extends('layouts.admin')

@section('title', $notice->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $notice->title }}</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <span>By {{ $notice->creator->name }}</span>
                <span>•</span>
                <span>{{ $notice->created_at->format('M d, Y \a\t H:i') }}</span>
                @if($notice->updated_at != $notice->created_at)
                    <span>•</span>
                    <span>Updated {{ $notice->updated_at->format('M d, Y \a\t H:i') }}</span>
                @endif
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.notices.edit', $notice) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.notices.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Notices
            </a>
        </div>
    </div>

    <!-- Notice Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Status and Metadata -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Status -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
                    @if($notice->is_active)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Active
                        </span>
                    @elseif($notice->is_expired)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Expired
                        </span>
                    @elseif($notice->status === 'published')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Published
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Draft
                        </span>
                    @endif
                </div>

                <!-- Published Date -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Published</h3>
                    @if($notice->published_at)
                        <p class="text-sm text-gray-900">{{ $notice->published_at->format('M d, Y \a\t H:i') }}</p>
                    @else
                        <p class="text-sm text-gray-400">Not published</p>
                    @endif
                </div>

                <!-- Valid Until -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Valid Until</h3>
                    @if($notice->valid_until)
                        <p class="text-sm text-gray-900">{{ $notice->valid_until->format('M d, Y') }}</p>
                        @if($notice->is_expired)
                            <p class="text-xs text-red-600 mt-1">Expired</p>
                        @endif
                    @else
                        <p class="text-sm text-gray-400">No expiry</p>
                    @endif
                </div>

                <!-- Last Updated -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Last Updated</h3>
                    <p class="text-sm text-gray-900">{{ $notice->updated_at->format('M d, Y') }}</p>
                    @if($notice->updater && $notice->updater->id !== $notice->creator->id)
                        <p class="text-xs text-gray-500">by {{ $notice->updater->name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Document Section -->
        @if($notice->document_file)
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Document</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-red-100 rounded-lg mr-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $notice->document_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $notice->document_size_formatted }} • {{ strtoupper($notice->document_type) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ $notice->document_url }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <a href="{{ $notice->document_url }}" 
                               download="{{ $notice->document_name }}"
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex gap-3">
                    <a href="{{ route('admin.notices.edit', $notice) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Notice
                    </a>
                    
                    @if($notice->status === 'draft')
                        <form action="{{ route('admin.notices.update', $notice) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="status" value="published">
                            <input type="hidden" name="published_at" value="{{ now()->format('Y-m-d\TH:i') }}">
                            @if($notice->valid_until)
                                <input type="hidden" name="valid_until" value="{{ $notice->valid_until->format('Y-m-d') }}">
                            @endif
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    onclick="return confirm('Are you sure you want to publish this notice?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Publish
                            </button>
                        </form>
                    @elseif($notice->status === 'published')
                        <form action="{{ route('admin.notices.update', $notice) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="status" value="draft">
                            @if($notice->published_at)
                                <input type="hidden" name="published_at" value="{{ $notice->published_at->format('Y-m-d\TH:i') }}">
                            @endif
                            @if($notice->valid_until)
                                <input type="hidden" name="valid_until" value="{{ $notice->valid_until->format('Y-m-d') }}">
                            @endif
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    onclick="return confirm('Are you sure you want to unpublish this notice?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 4h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17.294 15M10 14l4-2c.707-.707 1.707-.707 2.414 0l2.586 2.586c.707.707.707 1.707 0 2.414L17.294 19"></path>
                                </svg>
                                Unpublish
                            </button>
                        </form>
                    @endif
                </div>

                <form action="{{ route('admin.notices.destroy', $notice) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this notice? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection