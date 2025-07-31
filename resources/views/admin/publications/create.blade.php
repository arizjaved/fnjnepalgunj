@extends('layouts.admin')

@section('title', 'Add Content - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Add New Content</h1>
            <p class="text-gray-600">Create a new publication or economic activity document</p>
        </div>
        <a href="{{ route('admin.publications.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Enter content title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Content Type <span class="text-red-500">*</span>
                </label>
                <select id="type" 
                        name="type" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('type') border-red-500 @enderror"
                        required>
                    <option value="">Select content type</option>
                    <option value="publication" {{ old('type') === 'publication' ? 'selected' : '' }}>प्रकाशनहरू (Publications)</option>
                    <option value="economic_activity" {{ old('type') === 'economic_activity' ? 'selected' : '' }}>आर्थिक गतिविधि (Economic Activities)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Document Upload -->
            <div>
                <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                    Document <span class="text-red-500">*</span>
                </label>
                <input id="document" name="document" type="file" class="hidden" accept=".pdf,.doc,.docx" required>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors cursor-pointer" onclick="document.getElementById('document').click()">
                    <div class="space-y-1 text-center" id="upload-display">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <span class="font-medium text-[#0073b7] hover:text-[#004a7f]">Upload a document</span>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                    </div>
                </div>
                @error('document')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status and Published Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Publish Date
                    </label>
                    <input type="datetime-local" 
                           id="published_at" 
                           name="published_at" 
                           value="{{ old('published_at') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('published_at') border-red-500 @enderror">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to publish immediately when status is published</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.publications.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                    Create Content
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('document');
    const dropZone = document.querySelector('.border-dashed');
    const uploadDisplay = document.getElementById('upload-display');
    
    // File input change handler
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            uploadDisplay.innerHTML = `
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-gray-600"><strong>${fileName}</strong></p>
                <p class="text-xs text-gray-500">${fileSize} MB</p>
                <button type="button" onclick="clearFile()" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
            `;
        }
    });
    
    // Drag and drop handlers
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        dropZone.classList.add('border-[#0073b7]', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-[#0073b7]', 'bg-blue-50');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});

function clearFile() {
    const fileInput = document.getElementById('document');
    const uploadDisplay = document.getElementById('upload-display');
    fileInput.value = '';
    
    uploadDisplay.innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
            <span class="font-medium text-[#0073b7] hover:text-[#004a7f]">Upload a document</span>
            <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
    `;
}
</script>
@endsection