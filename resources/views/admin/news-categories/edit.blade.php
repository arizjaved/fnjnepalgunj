@extends('layouts.admin')

@section('title', 'Edit News Category')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit News Category</h1>
            <p class="text-gray-600">Update category information</p>
        </div>
        <a href="{{ route('admin.news-categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Categories</span>
        </a>
    </div>

    <form action="{{ route('admin.news-categories.update', $newsCategory) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Category Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('name') border-red-500 @enderror" 
                                   id="name" name="name" value="{{ old('name', $newsCategory->name) }}" required
                                   placeholder="Enter category name...">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('description') border-red-500 @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Brief description of the category...">{{ old('description', $newsCategory->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Optional description (max 1000 characters)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                                Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" 
                                       class="w-12 h-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('color') border-red-500 @enderror" 
                                       id="color" name="color" value="{{ old('color', $newsCategory->color) }}" required>
                                <input type="text" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('color') border-red-500 @enderror" 
                                       id="color-text" value="{{ old('color', $newsCategory->color) }}" 
                                       placeholder="#0073b7" pattern="^#[0-9A-Fa-f]{6}$">
                            </div>
                            @error('color')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Color for category identification</p>
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('sort_order') border-red-500 @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $newsCategory->sort_order) }}" min="0"
                                   placeholder="0">
                            @error('sort_order')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $newsCategory->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                <span class="ml-2 text-sm text-gray-700">Active Category</span>
                            </label>
                            <p class="text-gray-500 text-sm mt-1">Only active categories appear in forms</p>
                        </div>
                    </div>
                </div>

                <!-- Category Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created:</span>
                            <span class="text-sm text-gray-900">{{ $newsCategory->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Created by:</span>
                            <span class="text-sm text-gray-900">{{ $newsCategory->creator->name }}</span>
                        </div>
                        @if($newsCategory->updated_at != $newsCategory->created_at)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Last updated:</span>
                                <span class="text-sm text-gray-900">{{ $newsCategory->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        @if($newsCategory->updater)
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Updated by:</span>
                                <span class="text-sm text-gray-900">{{ $newsCategory->updater->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Slug:</span>
                            <code class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $newsCategory->slug }}</code>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Articles:</span>
                            <span class="text-sm text-gray-900">{{ $newsCategory->news()->count() }} articles</span>
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
                            <span>Update Category</span>
                        </button>
                        <a href="{{ route('admin.news-categories.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
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
    const colorPicker = document.getElementById('color');
    const colorText = document.getElementById('color-text');
    
    // Sync color picker with text input
    colorPicker.addEventListener('input', function() {
        colorText.value = this.value.toUpperCase();
    });
    
    colorText.addEventListener('input', function() {
        const value = this.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
            colorPicker.value = value;
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const color = document.getElementById('color').value;
        
        if (!name) {
            e.preventDefault();
            alert('Please enter a category name.');
            document.getElementById('name').focus();
            return;
        }
        
        if (!/^#[0-9A-Fa-f]{6}$/.test(color)) {
            e.preventDefault();
            alert('Please enter a valid hex color code (e.g., #0073b7).');
            document.getElementById('color-text').focus();
            return;
        }
    });
});
</script>
@endsection