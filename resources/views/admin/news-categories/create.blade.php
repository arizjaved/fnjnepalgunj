@extends('layouts.admin')

@section('title', 'Create News Category')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create News Category</h1>
            <p class="text-gray-600">Create a new category for organizing news articles</p>
        </div>
        <a href="{{ route('admin.news-categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Categories</span>
        </a>
    </div>

    <form action="{{ route('admin.news-categories.store') }}" method="POST" class="space-y-6">
        @csrf
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
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Enter category name...">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('description') border-red-500 @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Brief description of the category...">{{ old('description') }}</textarea>
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
                                       id="color" name="color" value="{{ old('color', '#0073b7') }}" required>
                                <input type="text" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('color') border-red-500 @enderror" 
                                       id="color-text" value="{{ old('color', '#0073b7') }}" 
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
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
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
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                <span class="ml-2 text-sm text-gray-700">Active Category</span>
                            </label>
                            <p class="text-gray-500 text-sm mt-1">Only active categories appear in forms</p>
                        </div>
                    </div>
                </div>

                <!-- Category Tips -->
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Category Tips</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Use clear, descriptive names
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Choose distinct colors for easy identification
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Use sort order to organize categories logically
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Categories help organize and filter content
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
                            <span>Create Category</span>
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