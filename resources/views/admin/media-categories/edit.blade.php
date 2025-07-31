@extends('layouts.admin')

@section('title', 'Edit Media Category - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Media Category</h1>
            <p class="text-gray-600">Update category information</p>
        </div>
        <a href="{{ route('admin.media-categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.media-categories.update', $mediaCategory) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $mediaCategory->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Category Type *</label>
                    <select id="type" name="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <option value="">Select Type</option>
                        <option value="photo" {{ old('type', $mediaCategory->type) == 'photo' ? 'selected' : '' }}>Photo Only</option>
                        <option value="video" {{ old('type', $mediaCategory->type) == 'video' ? 'selected' : '' }}>Video Only</option>
                        <option value="both" {{ old('type', $mediaCategory->type) == 'both' ? 'selected' : '' }}>Both Photo & Video</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                          placeholder="Optional description for this category">{{ old('description', $mediaCategory->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $mediaCategory->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-[#0073b7] border-gray-300 rounded focus:ring-[#0073b7]">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.media-categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg transition-colors">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection