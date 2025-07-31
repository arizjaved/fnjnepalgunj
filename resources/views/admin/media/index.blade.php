@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Media Library</h1>
            <p class="text-gray-600">Manage your uploaded files and images</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.media.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Upload Files
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Files</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Photo Gallery</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['images'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Documents</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['documents'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Video Gallery</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['videos'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Storage Used</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ number_format($stats['total_size'] / 1024 / 1024, 1) }} MB
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.media.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search media files..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            </div>
            <div class="sm:w-40">
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    <option value="">All Media</option>
                    <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Photo Gallery</option>
                    <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Video Gallery</option>
                    <option value="document" {{ request('type') === 'document' ? 'selected' : '' }}>Documents</option>
                    <option value="audio" {{ request('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    Search
                </button>
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('admin.media.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <form id="bulk-action-form" method="POST" action="{{ route('admin.media.bulk-delete') }}">
        @csrf
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <!-- Bulk Actions Bar -->
            <div class="p-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                            <span class="ml-2 text-sm text-gray-600">Select All</span>
                        </label>
                        <span id="selected-count" class="text-sm text-gray-500">0 selected</span>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled
                                onclick="return confirm('Are you sure you want to delete the selected files? This action cannot be undone.')">
                            Delete Selected
                        </button>
                    </div>
                </div>
            </div>

            <!-- Media Grid -->
            <div class="p-6">
                @if($media->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($media as $item)
                            <div class="relative group bg-gray-50 rounded-lg overflow-hidden border border-gray-200 hover:border-[#0073b7] transition-colors">
                                <input type="checkbox" 
                                       name="selected_items[]" 
                                       value="{{ $item->id }}" 
                                       class="item-checkbox absolute top-2 left-2 z-10 rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                
                                <div class="aspect-square relative">
                                    @if($item->is_image)
                                        <img src="{{ $item->url }}" 
                                             alt="{{ $item->alt_text ?: $item->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            @if($item->type === 'document')
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            @elseif($item->type === 'video')
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay with actions -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.media.show', $item) }}" 
                                               class="p-2 bg-white rounded-full text-gray-700 hover:text-[#0073b7] transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.media.download', $item) }}" 
                                               class="p-2 bg-white rounded-full text-gray-700 hover:text-green-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-3">
                                    <h3 class="text-sm font-medium text-gray-900 truncate" title="{{ $item->name }}">
                                        {{ $item->name }}
                                    </h3>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-xs text-gray-500">{{ $item->human_size }}</span>
                                        <span class="text-xs text-gray-400">{{ $item->created_at->format('M d') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No media files found</h3>
                        <p class="text-gray-500 mb-4">Upload your first files to get started.</p>
                        <a href="{{ route('admin.media.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Upload Files
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <!-- Pagination -->
    @if($media->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            {{ $media->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const deleteButton = bulkActionForm.querySelector('button[type="submit"]');
    
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCountSpan.textContent = `${count} selected`;
        deleteButton.disabled = count === 0;
        
        selectAllCheckbox.checked = count === itemCheckboxes.length;
        selectAllCheckbox.indeterminate = count > 0 && count < itemCheckboxes.length;
    }
    
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });
    
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    updateSelectedCount();
});
</script>
@endsection