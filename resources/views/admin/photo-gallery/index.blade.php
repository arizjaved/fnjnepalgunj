@extends('layouts.admin')

@section('title', 'Photo Gallery - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Photo Gallery</h1>
            <p class="text-gray-600">Manage photo gallery items</p>
        </div>
        <a href="{{ route('admin.photo-gallery.create') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Photo
        </a>
    </div>

    <!-- Photos Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($photos as $photo)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <img src="{{ $photo->image_url }}" alt="{{ $photo->image_alt }}" class="w-full h-48 object-cover">
                    <div class="absolute top-2 right-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $photo->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($photo->status) }}
                        </span>
                    </div>
                    @if($photo->category)
                        <div class="absolute top-2 left-2">
                            <span class="bg-[#0073b7] text-white px-2 py-1 rounded text-xs font-medium">
                                {{ $photo->category->name }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $photo->title }}</h3>
                    @if($photo->description)
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $photo->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span>{{ $photo->created_at->format('M d, Y') }}</span>
                        @if($photo->creator)
                            <span>by {{ $photo->creator->name }}</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.photo-gallery.show', $photo) }}" class="text-[#0073b7] hover:text-[#004a7f]" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.photo-gallery.edit', $photo) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.photo-gallery.destroy', $photo) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <span class="text-xs text-gray-500">Order: {{ $photo->sort_order }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No photos found</h3>
                <p class="text-gray-500 mb-4">Upload your first photo to get started.</p>
                <a href="{{ route('admin.photo-gallery.create') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg transition-colors">
                    Add Photo
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($photos->hasPages())
        <div class="flex justify-center">
            {{ $photos->links() }}
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection