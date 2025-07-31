@extends('layouts.admin')

@section('title', 'Edit News Article')

@push('styles')
<style>
    #drop-zone.drag-over {
        border-color: #0073b7 !important;
        background-color: #eff6ff !important;
        transform: scale(1.02);
    }
    
    #drop-zone {
        transition: all 0.3s ease;
    }
    
    .image-preview-container {
        transition: all 0.3s ease;
        transform: translateY(10px);
        opacity: 0;
    }
    
    .image-preview-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .current-image img {
        transition: all 0.3s ease;
    }
    
    .current-image:hover img {
        transform: scale(1.02);
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .field-feedback {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .validation-error {
        animation: slideIn 0.3s ease-out;
    }
    
    /* Loading overlay styles */
    #form-loading-overlay {
        backdrop-filter: blur(2px);
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Enhanced focus states */
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(0, 115, 183, 0.1);
        border-color: #0073b7;
        outline: none;
    }
    
    /* Character counter styling */
    #excerpt-counter {
        transition: all 0.3s ease;
    }
    
    /* Auto-save indicator styling */
    #autosave-indicator {
        transition: all 0.3s ease;
        opacity: 0;
    }
    
    #autosave-indicator:not(:empty) {
        opacity: 1;
    }
    
    /* Form validation styling */
    .validation-error {
        animation: slideIn 0.3s ease-out;
    }
    
    input.border-green-500, textarea.border-green-500, select.border-green-500 {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    /* Notification styling */
    .notification-enter {
        transform: translateX(100%);
        opacity: 0;
    }
    
    .notification-enter-active {
        transform: translateX(0);
        opacity: 1;
        transition: all 0.3s ease-out;
    }
    
    /* Keyboard focus improvements */
    *:focus {
        outline: 2px solid #0073b7;
        outline-offset: 2px;
    }
    
    /* Skip to content link for accessibility */
    .skip-link {
        position: absolute;
        top: -40px;
        left: 6px;
        background: #0073b7;
        color: white;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 1000;
    }
    
    .skip-link:focus {
        top: 6px;
    }
    
    /* Enhanced image preview animations */
    .image-preview-container {
        animation: slideInUp 0.4s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading states */
    .loading-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit News Article</h1>
            <p class="text-gray-600">Update your news article</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.news.show', $news) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>View</span>
            </a>
            <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to News</span>
            </a>
        </div>
    </div>



    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6" novalidate id="update-form">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Article Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Article Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Title <span class="text-red-500" aria-label="required">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" required
                                   placeholder="Enter article title..."
                                   aria-describedby="title-help"
                                   autocomplete="off">
                            <div id="title-help" class="sr-only">Enter a descriptive title for your news article. This field is required.</div>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('excerpt') border-red-500 @enderror" 
                                      id="excerpt" name="excerpt" rows="3" maxlength="500"
                                      placeholder="Brief summary of the article..."
                                      aria-describedby="excerpt-help excerpt-counter">{{ old('excerpt', $news->excerpt) }}</textarea>
                            <div id="excerpt-help" class="sr-only">Optional brief summary of the article. Maximum 500 characters.</div>
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
                                      placeholder="Write your article content here..."
                                      aria-describedby="content-help">{{ old('content', $news->content) }}</textarea>
                            <div id="content-help" class="sr-only">Main content of your news article. This field is required.</div>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h2>
                    @if($news->featured_image)
                        <div class="current-image mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Current Image</span>
                                <button type="button" onclick="removeCurrentImage()" class="text-red-600 hover:text-red-800 text-sm">Remove Current</button>
                            </div>
                            <img src="{{ $news->featured_image_url }}" alt="Current featured image" class="max-w-full h-48 object-cover rounded-lg">
                        </div>
                    @endif
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($news->featured_image)
                                Replace Image
                            @else
                                Upload Image
                            @endif
                        </label>
                        <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors cursor-pointer" 
                             role="button" 
                             tabindex="0" 
                             aria-label="Click to upload image or drag and drop"
                             aria-describedby="upload-help">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                                        <span>Upload a file</span>
                                        <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" aria-describedby="upload-help">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                @if($news->featured_image)
                                    <p class="text-xs text-gray-500">Leave empty to keep current image</p>
                                @endif
                                <div id="upload-help" class="sr-only">Upload a featured image for your article. Supported formats: PNG, JPG, GIF. Maximum size: 2MB.</div>
                            </div>
                        </div>
                        @error('featured_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publishing Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('category_id') border-red-500 @enderror" 
                                    id="category_id" name="category_id">
                                <option value="">Select Category (Optional)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('status') border-red-500 @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        

                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                <span class="ml-2 text-sm text-gray-700">Featured Article</span>
                            </label>
                            <p class="text-gray-500 text-sm mt-1">Featured articles appear in the homepage carousel</p>
                        </div>
                    </div>
                </div>

                <!-- Article Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Article Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created:</span>
                            <span class="text-sm text-gray-900">{{ $news->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created by:</span>
                            <span class="text-sm text-gray-900">{{ $news->creator->name }}</span>
                        </div>
                        @if($news->updated_at != $news->created_at)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Last updated:</span>
                                <span class="text-sm text-gray-900">{{ $news->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        @if($news->updater)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Updated by:</span>
                                <span class="text-sm text-gray-900">{{ $news->updater->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Slug:</span>
                            <code class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $news->slug }}</code>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Status:</span>
                            @if($news->status === 'published')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Draft</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        @if($news->status === 'published')
                            <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                <span>View on Website</span>
                            </a>
                        @endif

                    </div>
                </div>

                <!-- Publishing Tips -->
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Publishing Tips</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Keep titles concise and descriptive
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Use high-quality images (recommended: 800x600px)
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Published articles automatically get current timestamp
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Include relevant keywords for better SEO
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                    @method('PUT')
                        <button type="submit" class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span>Update Article</span>
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
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
    const titleInput = document.getElementById('title');
    const excerptInput = document.getElementById('excerpt');
    const contentInput = document.getElementById('content');
    const statusSelect = document.getElementById('status');

    const imageInput = document.getElementById('featured_image');
    const form = document.querySelector('form');
    
    // Initialize all functionality
    initializeCharacterCounter();
    initializeAutoSave();
    initializeFormValidation();
    initializeKeyboardNavigation();
    initializeStatusHandling();
    initializeImageHandling();

    
    // Character counter for excerpt field
    function initializeCharacterCounter() {
        if (!excerptInput) return;
        
        const maxLength = 500;
        let counter = document.getElementById('excerpt-counter');
        
        if (!counter) {
            counter = document.createElement('div');
            counter.id = 'excerpt-counter';
            counter.className = 'text-xs text-gray-500';
            excerptInput.parentNode.querySelector('.flex').appendChild(counter);
        }
        
        function updateCounter() {
            const currentLength = excerptInput.value.length;
            const remaining = maxLength - currentLength;
            counter.textContent = `${currentLength}/${maxLength} characters`;
            
            // Update styling based on remaining characters
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
        updateCounter(); // Initialize counter
    }
    
    // Auto-save functionality with indicators
    function initializeAutoSave() {
        let autoSaveTimeout;
        let hasUnsavedChanges = false;
        const formInputs = [titleInput, excerptInput, contentInput].filter(Boolean);
        
        // Create auto-save indicator
        function createAutoSaveIndicator() {
            let indicator = document.getElementById('autosave-indicator');
            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'autosave-indicator';
                indicator.className = 'text-xs mt-2 transition-all duration-300';
                titleInput.parentNode.appendChild(indicator);
            }
            return indicator;
        }
        
        function showAutoSaveIndicator(message, type = 'success') {
            const indicator = createAutoSaveIndicator();
            const colors = {
                success: 'text-green-600',
                saving: 'text-blue-600',
                error: 'text-red-600'
            };
            
            indicator.textContent = message;
            indicator.className = `text-xs mt-2 transition-all duration-300 ${colors[type]}`;
            
            if (type === 'success') {
                setTimeout(() => {
                    indicator.textContent = '';
                }, 3000);
            }
        }
        
        function saveFormData() {
            const formData = {
                title: titleInput.value,
                excerpt: excerptInput.value,
                content: contentInput.value,
                timestamp: Date.now()
            };
            
            try {
                localStorage.setItem('news_edit_draft_' + window.location.pathname, JSON.stringify(formData));
                showAutoSaveIndicator('Draft saved automatically');
                hasUnsavedChanges = false;
            } catch (e) {
                showAutoSaveIndicator('Failed to save draft', 'error');
            }
        }
        
        function loadFormData() {
            try {
                const saved = localStorage.getItem('news_edit_draft_' + window.location.pathname);
                if (saved) {
                    const data = JSON.parse(saved);
                    // Only load if it's recent (within 24 hours) and different from current values
                    if (Date.now() - data.timestamp < 24 * 60 * 60 * 1000) {
                        if (data.title !== titleInput.value || 
                            data.excerpt !== excerptInput.value || 
                            data.content !== contentInput.value) {
                            
                            if (confirm('Found a recent draft. Would you like to restore it?')) {
                                titleInput.value = data.title || titleInput.value;
                                excerptInput.value = data.excerpt || excerptInput.value;
                                contentInput.value = data.content || contentInput.value;
                                showAutoSaveIndicator('Draft restored');
                            }
                        }
                    }
                }
            } catch (e) {
                console.warn('Failed to load draft:', e);
            }
        }
        
        // Load saved draft on page load
        loadFormData();
        
        // Set up auto-save on input
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                hasUnsavedChanges = true;
                clearTimeout(autoSaveTimeout);
                showAutoSaveIndicator('Saving...', 'saving');
                
                autoSaveTimeout = setTimeout(() => {
                    saveFormData();
                }, 2000);
            });
        });
        
        // Clear draft on successful form submission
        form.addEventListener('submit', function() {
            localStorage.removeItem('news_edit_draft_' + window.location.pathname);
        });
        
        // Warn about unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
    }
    
    // Enhanced form validation
    function initializeFormValidation() {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalSubmitText = submitBtn.innerHTML;
        
        // Real-time validation
        function validateField(field, rules) {
            const value = field.value.trim();
            let isValid = true;
            let message = '';
            
            if (rules.required && !value) {
                isValid = false;
                message = 'This field is required';
            } else if (rules.minLength && value.length < rules.minLength) {
                isValid = false;
                message = `Minimum ${rules.minLength} characters required`;
            } else if (rules.maxLength && value.length > rules.maxLength) {
                isValid = false;
                message = `Maximum ${rules.maxLength} characters allowed`;
            }
            
            showFieldValidation(field, isValid, message);
            return isValid;
        }
        
        function showFieldValidation(field, isValid, message) {
            // Remove existing validation message
            const existingError = field.parentNode.querySelector('.validation-error');
            if (existingError) existingError.remove();
            
            // Update field styling
            if (isValid) {
                field.classList.remove('border-red-500');
                field.classList.add('border-green-500');
            } else {
                field.classList.remove('border-green-500');
                field.classList.add('border-red-500');
                
                // Add error message
                if (message) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'validation-error text-red-500 text-sm mt-1';
                    errorDiv.textContent = message;
                    field.parentNode.appendChild(errorDiv);
                }
            }
        }
        
        // Set up real-time validation
        titleInput.addEventListener('blur', () => validateField(titleInput, { required: true, minLength: 3, maxLength: 200 }));
        contentInput.addEventListener('blur', () => validateField(contentInput, { required: true, minLength: 10 }));
        if (excerptInput) {
            excerptInput.addEventListener('blur', () => validateField(excerptInput, { maxLength: 500 }));
        }
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            const titleValid = validateField(titleInput, { required: true, minLength: 3, maxLength: 200 });
            const contentValid = validateField(contentInput, { required: true, minLength: 10 });
            const excerptValid = excerptInput ? validateField(excerptInput, { maxLength: 500 }) : true;
            
            if (!titleValid || !contentValid || !excerptValid) {
                e.preventDefault();
                
                // Focus on first invalid field
                const firstInvalid = form.querySelector('.border-red-500');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Show loading state
            showFormLoading(submitBtn, originalSubmitText);
        });
    }
    
    // Enhanced keyboard navigation
    function initializeKeyboardNavigation() {
        // Tab order management
        const focusableElements = form.querySelectorAll(
            'input:not([disabled]), textarea:not([disabled]), select:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"])'
        );
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                form.dispatchEvent(new Event('submit', { cancelable: true }));
            }
            
            // Escape to cancel/go back
            if (e.key === 'Escape') {
                const cancelBtn = form.querySelector('a[href*="news.index"]');
                if (cancelBtn && confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                    window.location.href = cancelBtn.href;
                }
            }
            
            // Enhanced tab navigation
            if (e.key === 'Tab') {
                const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);
                if (e.shiftKey && currentIndex === 0) {
                    e.preventDefault();
                    focusableElements[focusableElements.length - 1].focus();
                } else if (!e.shiftKey && currentIndex === focusableElements.length - 1) {
                    e.preventDefault();
                    focusableElements[0].focus();
                }
            }
        });
        
        // ARIA labels and descriptions
        titleInput.setAttribute('aria-describedby', 'title-help');
        contentInput.setAttribute('aria-describedby', 'content-help');
        if (excerptInput) {
            excerptInput.setAttribute('aria-describedby', 'excerpt-help excerpt-counter');
        }
    }
    
    // Status handling (simplified since publish date is handled server-side)
    function initializeStatusHandling() {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'published') {
                // Show notification
                showNotification('Article will be published with current timestamp', 'info');
            }
        });
    }
    
    // Enhanced image handling
    function initializeImageHandling() {
        const dropZone = document.getElementById('drop-zone');
        if (!dropZone) return;
        
        // Enhanced drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        dropZone.addEventListener('drop', handleDrop, false);
        dropZone.addEventListener('click', () => imageInput.click());
        
        // Keyboard support for drop zone
        dropZone.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                imageInput.click();
            }
        });
        
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleImageFile(file);
            }
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight(e) {
            dropZone.classList.add('drag-over');
        }
        
        function unhighlight(e) {
            dropZone.classList.remove('drag-over');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                imageInput.files = files;
                handleImageFile(files[0]);
            }
        }
        
        function handleImageFile(file) {
            // Comprehensive file validation
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            const minSize = 1024; // 1KB
            
            // Validate file type
            if (!allowedTypes.includes(file.type.toLowerCase())) {
                const supportedFormats = allowedTypes.map(type => type.split('/')[1].toUpperCase()).join(', ');
                showError(
                    'Invalid file format. Please select a valid image file.',
                    `Supported formats: ${supportedFormats}. Selected: ${file.type || 'Unknown'}`
                );
                imageInput.value = '';
                return;
            }
            
            // Validate file size
            if (file.size > maxSize) {
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                showError(
                    'File size is too large. Maximum allowed size is 2MB.',
                    `Your file is ${fileSizeMB}MB. Please compress or choose a smaller image.`
                );
                imageInput.value = '';
                return;
            }
            
            if (file.size < minSize) {
                showError(
                    'File size is too small. This might be a corrupted image.',
                    'Please select a valid image file that is at least 1KB in size.'
                );
                imageInput.value = '';
                return;
            }
            
            // Show loading state while processing
            showImageProcessing();
            
            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                // Validate image dimensions
                const img = new Image();
                img.onload = function() {
                    hideImageProcessing();
                    
                    // Check minimum dimensions
                    if (this.naturalWidth < 100 || this.naturalHeight < 100) {
                        showError(
                            'Image dimensions are too small.',
                            `Minimum size: 100×100px. Your image: ${this.naturalWidth}×${this.naturalHeight}px`
                        );
                        imageInput.value = '';
                        return;
                    }
                    
                    // Check maximum dimensions
                    if (this.naturalWidth > 5000 || this.naturalHeight > 5000) {
                        showError(
                            'Image dimensions are too large.',
                            `Maximum size: 5000×5000px. Your image: ${this.naturalWidth}×${this.naturalHeight}px`
                        );
                        imageInput.value = '';
                        return;
                    }
                    
                    // All validations passed, create preview
                    createImagePreview(e.target.result, file);
                };
                
                img.onerror = function() {
                    hideImageProcessing();
                    showError(
                        'Unable to process the image file.',
                        'The file might be corrupted or not a valid image format.'
                    );
                    imageInput.value = '';
                };
                
                img.src = e.target.result;
            };
            
            reader.onerror = function() {
                hideImageProcessing();
                showError(
                    'Failed to read the image file.',
                    'Please try selecting the file again or choose a different image.'
                );
                imageInput.value = '';
            };
            
            reader.readAsDataURL(file);
        }
        
        function showImageProcessing() {
            const existingProcessing = document.getElementById('image-processing');
            if (existingProcessing) return;
            
            const processing = document.createElement('div');
            processing.id = 'image-processing';
            processing.className = 'mt-4 p-4 bg-blue-50 border-2 border-blue-200 rounded-lg';
            processing.innerHTML = `
                <div class="flex items-center">
                    <svg class="animate-spin w-5 h-5 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Processing image...</p>
                        <p class="text-xs text-blue-600">Validating format and dimensions</p>
                    </div>
                </div>
            `;
            dropZone.after(processing);
        }
        
        function hideImageProcessing() {
            const processing = document.getElementById('image-processing');
            if (processing) {
                processing.remove();
            }
        }
        
        function createImagePreview(src, file) {
            // Remove existing preview and errors
            const existingPreview = document.getElementById('image-preview');
            const existingError = document.getElementById('image-error');
            if (existingPreview) existingPreview.remove();
            if (existingError) existingError.remove();
            
            // Create new preview with enhanced styling
            const preview = document.createElement('div');
            preview.id = 'image-preview';
            preview.className = 'image-preview-container mt-4 p-4 border-2 border-green-200 rounded-lg bg-green-50 transition-all duration-300';
            
            // Get image dimensions for display
            const img = new Image();
            img.onload = function() {
                const dimensions = `${this.naturalWidth} × ${this.naturalHeight}px`;
                updatePreviewInfo(dimensions);
            };
            img.src = src;
            
            preview.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-800">New Image Selected</span>
                    </div>
                    <button type="button" onclick="removeImagePreview()" class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors">Remove</button>
                </div>
                <img src="${src}" alt="New image preview" class="max-w-full h-48 object-cover rounded-lg mb-3">
                <div class="grid grid-cols-2 gap-4 text-xs text-green-700">
                    <div>
                        <span class="font-medium">File:</span> ${file.name}
                    </div>
                    <div>
                        <span class="font-medium">Size:</span> ${(file.size / 1024 / 1024).toFixed(2)} MB
                    </div>
                    <div id="preview-dimensions">
                        <span class="font-medium">Dimensions:</span> Loading...
                    </div>
                    <div>
                        <span class="font-medium">Type:</span> ${file.type}
                    </div>
                </div>
            `;
            
            dropZone.after(preview);
            
            function updatePreviewInfo(dimensions) {
                const dimensionsEl = document.getElementById('preview-dimensions');
                if (dimensionsEl) {
                    dimensionsEl.innerHTML = `<span class="font-medium">Dimensions:</span> ${dimensions}`;
                }
            }
        }
    }
    
    // Form progress tracking
    function initializeFormProgress() {
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('form-progress');
        
        if (!progressBar || !progressText) return;
        
        function calculateProgress() {
            let completedFields = 0;
            let totalFields = 0;
            
            // Required fields
            const requiredFields = [
                { element: titleInput, weight: 2 },
                { element: contentInput, weight: 3 }
            ];
            
            // Optional fields
            const optionalFields = [
                { element: excerptInput, weight: 1 },
                { element: imageInput, weight: 1 },
                { element: statusSelect, weight: 1 }
            ];
            
            // Calculate required fields progress
            requiredFields.forEach(field => {
                totalFields += field.weight;
                if (field.element && field.element.value.trim()) {
                    completedFields += field.weight;
                }
            });
            
            // Calculate optional fields progress
            optionalFields.forEach(field => {
                totalFields += field.weight;
                if (field.element && field.element.value && field.element.value.trim()) {
                    completedFields += field.weight;
                } else if (field.element === imageInput && field.element.files.length > 0) {
                    completedFields += field.weight;
                }
            });
            
            const percentage = Math.round((completedFields / totalFields) * 100);
            
            progressBar.style.width = `${percentage}%`;
            progressText.textContent = `${percentage}%`;
            
            // Update color based on progress
            if (percentage < 30) {
                progressBar.className = 'bg-red-500 h-2 rounded-full transition-all duration-300';
            } else if (percentage < 70) {
                progressBar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-300';
            } else {
                progressBar.className = 'bg-green-500 h-2 rounded-full transition-all duration-300';
            }
        }
        
        // Update progress on input changes
        [titleInput, excerptInput, contentInput, statusSelect, imageInput].forEach(element => {
            if (element) {
                element.addEventListener('input', calculateProgress);
                element.addEventListener('change', calculateProgress);
            }
        });
        
        // Initial calculation
        calculateProgress();
    }
    
    // Utility functions
    function showError(title, message) {
        // Remove existing error
        const existingError = document.getElementById('image-error');
        if (existingError) existingError.remove();
        
        const error = document.createElement('div');
        error.id = 'image-error';
        error.className = 'mt-4 p-4 border-2 border-red-200 rounded-lg bg-red-50';
        error.innerHTML = `
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-800">${title}</p>
                    <p class="text-xs text-red-600 mt-1">${message}</p>
                </div>
            </div>
        `;
        
        const dropZone = document.getElementById('drop-zone');
        dropZone.after(error);
        
        // Auto-remove error after 10 seconds
        setTimeout(() => {
            if (error.parentNode) {
                error.remove();
            }
        }, 10000);
    }
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const colors = {
            info: 'bg-blue-50 border-blue-200 text-blue-800',
            success: 'bg-green-50 border-green-200 text-green-800',
            warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
            error: 'bg-red-50 border-red-200 text-red-800'
        };
        
        notification.className = `fixed top-4 right-4 p-4 border rounded-lg ${colors[type]} z-50 transition-all duration-300 transform translate-x-full`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Slide in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
    }
    
    function showFormLoading(submitBtn, originalText) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Updating Article...</span>
        `;
        
        // Create loading overlay
        const overlay = document.createElement('div');
        overlay.id = 'form-loading-overlay';
        overlay.className = 'fixed inset-0 bg-black bg-opacity-25 z-40';
        document.body.appendChild(overlay);
        
        // Reset button state if form submission fails (fallback)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            if (overlay.parentNode) {
                overlay.remove();
            }
        }, 30000);
    }
});

// Global functions for template usage
function removeImagePreview() {
    const preview = document.getElementById('image-preview');
    const imageInput = document.getElementById('featured_image');
    if (preview) {
        preview.remove();
    }
    if (imageInput) {
        imageInput.value = '';
    }
}

function removeCurrentImage() {
    const currentImageDiv = document.querySelector('.current-image');
    if (currentImageDiv && confirm('Are you sure you want to remove the current image?')) {
        currentImageDiv.style.display = 'none';
        
        // Add hidden input to indicate image removal
        let removeInput = document.getElementById('remove_current_image');
        if (!removeInput) {
            removeInput = document.createElement('input');
            removeInput.type = 'hidden';
            removeInput.name = 'remove_current_image';
            removeInput.id = 'remove_current_image';
            removeInput.value = '1';
            document.querySelector('form').appendChild(removeInput);
        }
    }
}een-800">New Image Selected</span>
                </div>
                <button type="button" onclick="removeImagePreview()" class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors px-2 py-1 rounded hover:bg-red-100">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Remove
                </button>
            </div>
            <div class="relative group">
                <img src="${src}" alt="Preview" class="max-w-full h-48 object-cover rounded-lg shadow-sm transition-transform group-hover:scale-105">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 rounded-lg"></div>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-600 font-medium">File:</span>
                    <p class="text-gray-800 truncate" title="${file.name}">${file.name}</p>
                </div>
                <div>
                    <span class="text-gray-600 font-medium">Size:</span>
                    <p class="text-gray-800">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
                <div>
                    <span class="text-gray-600 font-medium">Type:</span>
                    <p class="text-gray-800">${file.type}</p>
                </div>
                <div id="image-dimensions">
                    <span class="text-gray-600 font-medium">Dimensions:</span>
                    <p class="text-gray-800">Loading...</p>
                </div>
            </div>
        `;
        
        function updatePreviewInfo(dimensions) {
            const dimensionsElement = preview.querySelector('#image-dimensions p');
            if (dimensionsElement) {
                dimensionsElement.textContent = dimensions;
            }
        }
        
        // Insert preview after the current image or drop zone
        const currentImageDiv = document.querySelector('.current-image');
        if (currentImageDiv) {
            currentImageDiv.after(preview);
        } else {
            dropZone.after(preview);
        }
        
        // Animate in
        setTimeout(() => {
            preview.style.transform = 'translateY(0)';
            preview.style.opacity = '1';
        }, 10);
    }
    
    function showError(message, details = null) {
        // Remove existing error and preview
        const existingError = document.getElementById('image-error');
        const existingPreview = document.getElementById('image-preview');
        if (existingError) existingError.remove();
        if (existingPreview) existingPreview.remove();
        
        // Create enhanced error message
        const error = document.createElement('div');
        error.id = 'image-error';
        error.className = 'mt-4 p-4 bg-red-50 border-2 border-red-200 rounded-lg animate-pulse';
        
        let errorContent = `
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-red-800 mb-1">Image Upload Error</h4>
                    <p class="text-sm text-red-700">${message}</p>
        `;
        
        if (details) {
            errorContent += `<p class="text-xs text-red-600 mt-1">${details}</p>`;
        }
        
        errorContent += `
                    <button type="button" onclick="document.getElementById('image-error').remove()" class="mt-2 text-xs text-red-600 hover:text-red-800 underline">
                        Dismiss
                    </button>
                </div>
            </div>
        `;
        
        error.innerHTML = errorContent;
        dropZone.after(error);
        
        // Add shake animation
        error.style.animation = 'shake 0.5s ease-in-out';
        
        // Auto-remove error after 8 seconds
        setTimeout(() => {
            if (error.parentNode) {
                error.style.opacity = '0';
                error.style.transform = 'translateY(-10px)';
                setTimeout(() => error.remove(), 300);
            }
        }, 8000);
    }
    
    // Enhanced character counter for excerpt
    const excerptInput = document.getElementById('excerpt');
    if (excerptInput) {
        const maxLength = 500;
        const counter = document.getElementById('excerpt-counter');
        
        function updateCounter() {
            const currentLength = excerptInput.value.length;
            const remaining = maxLength - currentLength;
            counter.textContent = `${currentLength}/${maxLength}`;
            
            // Update styling based on character count
            if (remaining < 50) {
                counter.className = 'text-xs text-red-500 font-medium';
                excerptInput.classList.add('border-yellow-300');
                excerptInput.classList.remove('border-gray-300');
            } else if (remaining < 100) {
                counter.className = 'text-xs text-yellow-600 font-medium';
                excerptInput.classList.add('border-yellow-300');
                excerptInput.classList.remove('border-gray-300');
            } else {
                counter.className = 'text-xs text-gray-500';
                excerptInput.classList.remove('border-yellow-300');
                excerptInput.classList.add('border-gray-300');
            }
            
            // Prevent typing beyond limit
            if (currentLength >= maxLength) {
                counter.className = 'text-xs text-red-500 font-bold';
            }
        }
        
        excerptInput.addEventListener('input', updateCounter);
        excerptInput.addEventListener('paste', function() {
            setTimeout(updateCounter, 10);
        });
        updateCounter();
    }
    
    // Real-time validation feedback
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    
    // Add input event listeners for real-time validation
    if (titleInput) {
        titleInput.addEventListener('input', function() {
            validateField(this, 'title');
        });
        titleInput.addEventListener('blur', function() {
            validateField(this, 'title');
        });
    }
    
    if (contentInput) {
        contentInput.addEventListener('input', function() {
            validateField(this, 'content');
        });
        contentInput.addEventListener('blur', function() {
            validateField(this, 'content');
        });
    }
    
    if (excerptInput) {
        excerptInput.addEventListener('input', function() {
            validateField(this, 'excerpt');
        });
        excerptInput.addEventListener('blur', function() {
            validateField(this, 'excerpt');
        });
    }
    
    function validateField(field, type) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';
        
        // Clear existing validation state
        field.classList.remove('border-red-500', 'border-green-500', 'bg-red-50', 'bg-green-50');
        const existingFeedback = field.parentNode.querySelector('.field-feedback');
        if (existingFeedback) existingFeedback.remove();
        
        // Validate based on field type
        switch (type) {
            case 'title':
                if (value.length === 0) {
                    // Don't show error for empty field unless it's been focused and blurred
                    if (field.dataset.touched) {
                        isValid = false;
                        message = 'Title is required';
                    }
                } else if (value.length < 5) {
                    isValid = false;
                    message = 'Title must be at least 5 characters';
                } else if (value.length > 255) {
                    isValid = false;
                    message = 'Title cannot exceed 255 characters';
                } else {
                    showFieldSuccess(field, 'Title looks good');
                }
                break;
                
            case 'content':
                if (value.length === 0) {
                    if (field.dataset.touched) {
                        isValid = false;
                        message = 'Content is required';
                    }
                } else if (value.length < 50) {
                    isValid = false;
                    message = `Content needs ${50 - value.length} more characters`;
                } else {
                    showFieldSuccess(field, 'Content length is good');
                }
                break;
                
            case 'excerpt':
                if (value.length > 500) {
                    isValid = false;
                    message = `Excerpt is ${value.length - 500} characters too long`;
                }
                break;
        }
        
        // Mark field as touched when it loses focus
        field.addEventListener('blur', function() {
            this.dataset.touched = 'true';
        }, { once: true });
        
        if (!isValid && message) {
            showFieldValidationError(field, message);
        }
    }
    
    function showFieldValidationError(field, message) {
        field.classList.add('border-red-500', 'bg-red-50');
        field.classList.remove('border-gray-300', 'border-green-500', 'bg-green-50');
        
        const feedback = document.createElement('div');
        feedback.className = 'field-feedback flex items-center mt-1';
        feedback.innerHTML = `
            <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-xs text-red-600">${message}</span>
        `;
        field.parentNode.appendChild(feedback);
    }
    
    function showFieldSuccess(field, message) {
        field.classList.add('border-green-500', 'bg-green-50');
        field.classList.remove('border-gray-300', 'border-red-500', 'bg-red-50');
        
        const feedback = document.createElement('div');
        feedback.className = 'field-feedback flex items-center mt-1';
        feedback.innerHTML = `
            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-xs text-green-600">${message}</span>
        `;
        field.parentNode.appendChild(feedback);
        
        // Auto-remove success message after 3 seconds
        setTimeout(() => {
            if (feedback.parentNode) {
                feedback.remove();
                field.classList.remove('border-green-500', 'bg-green-50');
                field.classList.add('border-gray-300');
            }
        }, 3000);
    }
    
    // Auto-save functionality for better UX
    let autoSaveTimeout;
    let hasUnsavedChanges = false;
    const formInputs = document.querySelectorAll('#title, #excerpt, #content, #status');
    
    // Track changes
    formInputs.forEach(input => {
        const originalValue = input.value;
        
        input.addEventListener('input', function() {
            hasUnsavedChanges = this.value !== originalValue;
            clearTimeout(autoSaveTimeout);
            
            if (hasUnsavedChanges) {
                showUnsavedIndicator();
                // Auto-save after 3 seconds of inactivity
                autoSaveTimeout = setTimeout(() => {
                    performAutoSave();
                }, 3000);
            }
        });
    });
    
    function showUnsavedIndicator() {
        let indicator = document.getElementById('unsaved-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'unsaved-indicator';
            indicator.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
            document.body.appendChild(indicator);
        }
        
        indicator.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-medium">Unsaved changes</span>
            </div>
        `;
    }
    
    function performAutoSave() {
        if (!hasUnsavedChanges) return;
        
        const indicator = document.getElementById('unsaved-indicator');
        if (indicator) {
            indicator.innerHTML = `
                <div class="flex items-center">
                    <svg class="animate-spin w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium">Auto-saving...</span>
                </div>
            `;
            indicator.className = 'fixed top-4 right-4 bg-blue-100 border border-blue-300 text-blue-800 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
        }
        
        // Simulate auto-save (in a real implementation, you'd send an AJAX request)
        setTimeout(() => {
            showAutoSaveSuccess();
            hasUnsavedChanges = false;
        }, 1000);
    }
    
    function showAutoSaveSuccess() {
        const indicator = document.getElementById('unsaved-indicator');
        if (indicator) {
            indicator.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Draft saved</span>
                </div>
            `;
            indicator.className = 'fixed top-4 right-4 bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
            
            // Hide after 3 seconds
            setTimeout(() => {
                indicator.style.opacity = '0';
                indicator.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (indicator.parentNode) {
                        indicator.remove();
                    }
                }, 300);
            }, 3000);
        }
    }
    
    // Warn user about unsaved changes when leaving page
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
    
    // Clear unsaved changes flag when form is submitted
    document.querySelector('form').addEventListener('submit', function() {
        hasUnsavedChanges = false;
    });
});

// Global function to remove image preview
function removeImagePreview() {
    const preview = document.getElementById('image-preview');
    const imageInput = document.getElementById('featured_image');
    const error = document.getElementById('image-error');
    
    if (preview) {
        preview.remove();
    }
    if (error) {
        error.remove();
    }
    if (imageInput) {
        imageInput.value = '';
    }
}

// Global function to remove current image (for edit context)
function removeCurrentImage() {
    const currentImageDiv = document.querySelector('.current-image');
    if (currentImageDiv && confirm('Are you sure you want to remove the current image? This will delete the image when you save the article.')) {
        // Add a hidden input to indicate image removal
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_featured_image';
        removeInput.value = '1';
        document.querySelector('form').appendChild(removeInput);
        
        // Hide the current image div
        currentImageDiv.style.display = 'none';
        
        // Update the label text
        const label = document.querySelector('label[for="featured_image"]');
        if (label) {
            label.textContent = 'Upload Image';
        }
        
        // Update the help text
        const helpText = document.querySelector('.text-xs.text-gray-500');
        if (helpText && helpText.textContent.includes('Leave empty to keep current image')) {
            helpText.textContent = 'PNG, JPG, GIF up to 2MB';
        }
    }
}

// Enhanced form validation with visual feedback
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const excerpt = document.getElementById('excerpt');
    let hasErrors = false;
    
    // Clear previous validation states
    clearValidationErrors();
    
    // Validate title
    if (!title.value.trim()) {
        showFieldError(title, 'Please enter a title for the article.');
        hasErrors = true;
    } else if (title.value.trim().length < 5) {
        showFieldError(title, 'Title must be at least 5 characters long.');
        hasErrors = true;
    }
    
    // Validate content
    if (!content.value.trim()) {
        showFieldError(content, 'Please enter content for the article.');
        hasErrors = true;
    } else if (content.value.trim().length < 50) {
        showFieldError(content, 'Content must be at least 50 characters long.');
        hasErrors = true;
    }
    
    // Validate excerpt length
    if (excerpt.value.length > 500) {
        showFieldError(excerpt, 'Excerpt cannot exceed 500 characters.');
        hasErrors = true;
    }
    
    if (hasErrors) {
        e.preventDefault();
        // Scroll to first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    // Show loading state
    showLoadingState();
});

function showFieldError(field, message) {
    // Add error styling to field
    field.classList.add('border-red-500', 'bg-red-50');
    field.classList.remove('border-gray-300');
    
    // Create or update error message
    let errorElement = field.parentNode.querySelector('.validation-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'validation-error flex items-center mt-2 p-2 bg-red-50 border border-red-200 rounded-lg';
        field.parentNode.appendChild(errorElement);
    }
    
    errorElement.innerHTML = `
        <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-sm text-red-700">${message}</span>
    `;
    
    // Focus the field
    field.focus();
}

function clearValidationErrors() {
    // Remove error styling from all fields
    const fields = document.querySelectorAll('input, textarea, select');
    fields.forEach(field => {
        field.classList.remove('border-red-500', 'bg-red-50');
        field.classList.add('border-gray-300');
    });
    
    // Remove all error messages
    const errorElements = document.querySelectorAll('.validation-error');
    errorElements.forEach(element => element.remove());
}

function showLoadingState() {
    const submitBtn = document.querySelector('button[type="submit"]');
    const cancelBtn = document.querySelector('a[href*="admin.news.index"]');
    const originalText = submitBtn.innerHTML;
    
    // Disable form elements
    submitBtn.disabled = true;
    if (cancelBtn) cancelBtn.style.pointerEvents = 'none';
    
    // Show loading spinner
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Updating Article...</span>
    `;
    
    // Add loading overlay to form
    const form = document.querySelector('form');
    const overlay = document.createElement('div');
    overlay.id = 'form-loading-overlay';
    overlay.className = 'absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10';
    overlay.innerHTML = `
        <div class="text-center">
            <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm text-gray-600">Updating your article...</p>
        </div>
    `;
    
    form.style.position = 'relative';
    form.appendChild(overlay);
    
    // Reset button state if form submission fails (fallback)
    setTimeout(() => {
        const overlay = document.getElementById('form-loading-overlay');
        if (overlay) overlay.remove();
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        if (cancelBtn) cancelBtn.style.pointerEvents = 'auto';
    }, 15000);
}

// Add form submission debugging
document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.querySelector('#update-form');
    if (updateForm) {
        updateForm.addEventListener('submit', function(e) {
            console.log('Form submission detected');
            console.log('Form action:', updateForm.action);
            console.log('Form method:', updateForm.method);
            console.log('Method input:', updateForm.querySelector('input[name="_method"]')?.value);
            
            // Let the form submit normally
            return true;
        });
    }
});
</script>
@endsection