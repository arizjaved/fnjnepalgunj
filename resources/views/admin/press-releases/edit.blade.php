@extends('layouts.admin')

@section('title', 'Edit Press Release')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Press Release</h1>
            <p class="text-gray-600">Update press release information</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.press-releases.show', $pressRelease) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View
            </a>
            <a href="{{ route('admin.press-releases.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Press Releases
            </a>
        </div>
    </div>

    <form action="{{ route('admin.press-releases.update', $pressRelease) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Press Release Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Press Release Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror" 
                                   id="title" name="title" value="{{ old('title', $pressRelease->title) }}" required
                                   placeholder="Enter press release title...">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('excerpt') border-red-500 @enderror" 
                                      id="excerpt" name="excerpt" rows="3" maxlength="500"
                                      placeholder="Brief summary of the press release...">{{ old('excerpt', $pressRelease->excerpt) }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-gray-500 text-sm">Optional short description (max 500 characters)</p>
                                <div id="excerpt-counter" class="text-xs text-gray-500"></div>
                            </div>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('content') border-red-500 @enderror" 
                                      id="content" name="content" rows="12" required
                                      placeholder="Write your press release content here...">{{ old('content', $pressRelease->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Document Upload -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Document Upload</h2>
                    
                    @if($pressRelease->document_file)
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $pressRelease->document_name ?: 'Current Document' }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ strtoupper($pressRelease->document_type ?: 'Document') }}
                                            @if($pressRelease->document_size_formatted)
                                                • {{ $pressRelease->document_size_formatted }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.press-releases.download', $pressRelease) }}" 
                                   class="text-[#0073b7] hover:text-[#004a7f] text-sm font-medium">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label for="document_file" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($pressRelease->document_file)
                                Replace Document
                            @else
                                Upload Document
                            @endif
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="document_file" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                                        <span>Upload a document</span>
                                        <input id="document_file" name="document_file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.txt,.rtf">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, TXT, RTF up to 5MB</p>
                                @if($pressRelease->document_file)
                                    <p class="text-xs text-gray-500">Leave empty to keep current document</p>
                                @endif
                            </div>
                        </div>
                        @error('document_file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3 width) -->
            <div class="space-y-6">
                <!-- Publishing Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('status') border-red-500 @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status', $pressRelease->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $pressRelease->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Press Release Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Press Release Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created:</span>
                            <span class="text-sm text-gray-900">{{ $pressRelease->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created by:</span>
                            <span class="text-sm text-gray-900">{{ $pressRelease->creator->name }}</span>
                        </div>
                        @if($pressRelease->updated_at != $pressRelease->created_at)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Last updated:</span>
                                <span class="text-sm text-gray-900">{{ $pressRelease->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        @if($pressRelease->updater)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Updated by:</span>
                                <span class="text-sm text-gray-900">{{ $pressRelease->updater->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Slug:</span>
                            <code class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $pressRelease->slug }}</code>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span>Update Press Release</span>
                        </button>
                        <a href="{{ route('admin.press-releases.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const excerptInput = document.getElementById('excerpt');
    const maxLength = 500;
    
    function updateCounter() {
        const currentLength = excerptInput.value.length;
        const remaining = maxLength - currentLength;
        const counter = document.getElementById('excerpt-counter');
        counter.textContent = `${currentLength}/${maxLength} characters`;
        
        if (remaining < 50) {
            counter.className = 'text-xs text-red-500';
        } else if (remaining < 100) {
            counter.className = 'text-xs text-yellow-600';
        } else {
            counter.className = 'text-xs text-gray-500';
        }
    }
    
    excerptInput.addEventListener('input', updateCounter);
    excerptInput.addEventListener('paste', () => setTimeout(updateCounter, 0));
    updateCounter();
});
</script>
@endsection