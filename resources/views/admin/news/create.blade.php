@extends('layouts.admin')

@section('title', 'Create News Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create News Article</h1>
            <p class="text-gray-600">Create a new news article for publication</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to News</span>
        </a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Article Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Article Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required
                                   placeholder="Enter article title...">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('excerpt') border-red-500 @enderror" 
                                      id="excerpt" name="excerpt" rows="3" 
                                      placeholder="Brief summary of the article...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Optional short description (max 500 characters)</p>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('content') border-red-500 @enderror" 
                                      id="content" name="content" rows="12" required
                                      placeholder="Write your article content here...">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h2>
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                                        <span>Upload a file</span>
                                        <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
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
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                <span class="ml-2 text-sm text-gray-700">Featured Article</span>
                            </label>
                            <p class="text-gray-500 text-sm mt-1">Featured articles appear in the homepage carousel</p>
                        </div>
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
                        <button type="submit" class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span>Create Article</span>
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
    const statusSelect = document.getElementById('status');
    const imageInput = document.getElementById('featured_image');
    

    
    // Image preview functionality
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                this.value = '';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                this.value = '';
                return;
            }
            
            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                const existingPreview = document.getElementById('image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Create new preview
                const preview = document.createElement('div');
                preview.id = 'image-preview';
                preview.className = 'mt-4 p-4 border border-gray-200 rounded-lg bg-gray-50';
                preview.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Image Preview</span>
                        <button type="button" onclick="removeImagePreview()" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                    </div>
                    <img src="${e.target.result}" alt="Preview" class="max-w-full h-48 object-cover rounded-lg">
                    <p class="text-xs text-gray-500 mt-2">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</p>
                `;
                
                // Insert preview after the file input container
                imageInput.closest('.bg-white').appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Character counter for excerpt
    const excerptInput = document.getElementById('excerpt');
    if (excerptInput) {
        const maxLength = 500;
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 mt-1 text-right';
        counter.id = 'excerpt-counter';
        excerptInput.parentNode.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - excerptInput.value.length;
            counter.textContent = `${excerptInput.value.length}/${maxLength} characters`;
            counter.className = remaining < 50 ? 'text-xs text-red-500 mt-1 text-right' : 'text-xs text-gray-500 mt-1 text-right';
        }
        
        excerptInput.addEventListener('input', updateCounter);
        updateCounter();
    }
    
    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    const formInputs = document.querySelectorAll('#title, #excerpt, #content');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Show auto-save indicator
                showAutoSaveIndicator();
            }, 2000);
        });
    });
    
    function showAutoSaveIndicator() {
        const indicator = document.getElementById('autosave-indicator') || createAutoSaveIndicator();
        indicator.textContent = 'Draft saved automatically';
        indicator.className = 'text-xs text-green-600 mt-1';
        setTimeout(() => {
            indicator.textContent = '';
        }, 3000);
    }
    
    function createAutoSaveIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'autosave-indicator';
        indicator.className = 'text-xs text-green-600 mt-1';
        titleInput.parentNode.appendChild(indicator);
        return indicator;
    }
});

// Global function to remove image preview
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

// Form validation before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (!title) {
        e.preventDefault();
        alert('Please enter a title for the article.');
        document.getElementById('title').focus();
        return;
    }
    
    if (!content) {
        e.preventDefault();
        alert('Please enter content for the article.');
        document.getElementById('content').focus();
        return;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Creating Article...
    `;
    
    // Reset button state if form submission fails
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 10000);
});
</script>
@endsection