@extends('layouts.app')

@section('title', 'फोटो ग्यालरी - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'फोटो ग्यालरी')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">फोटो ग्यालरी</h1>
    
    <!-- Category Filter -->
    @if($categories->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    श्रेणी अनुसार छान्नुहोस्
                </h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('photo-gallery') }}" class="px-4 py-2 {{ !request('category') ? 'bg-[#0073b7] text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-[#004a7f] hover:text-white transition-colors text-sm font-medium">
                        सबै ({{ $photos->total() }})
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('photo-gallery', ['category' => $category->slug]) }}" class="px-4 py-2 {{ request('category') == $category->slug ? 'bg-[#0073b7] text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-[#004a7f] hover:text-white transition-colors text-sm">
                            {{ $category->name }} ({{ $category->photo_galleries_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($photos as $photo)
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer transform hover:-translate-y-2" onclick="openPhotoModal('{{ $photo->image_url }}', '{{ $photo->title }}', '{{ $photo->description }}', '{{ $photo->category->name ?? '' }}')">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $photo->image_url }}" alt="{{ $photo->image_alt }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-4 transform scale-75 group-hover:scale-100 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $photo->title }}</h3>
                    @if($photo->category)
                        <div class="flex items-center space-x-2">
                            <span class="bg-[#0073b7]/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium">
                                {{ $photo->category->name }}
                            </span>
                        </div>
                    @endif
                    @if($photo->description)
                        <p class="text-white/90 text-sm mt-2 line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                            {{ $photo->description }}
                        </p>
                    @endif
                </div>
                
                <!-- Corner decoration -->
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">कुनै फोटो फेला परेन</h3>
                <p class="text-gray-500">यस श्रेणीमा कुनै फोटो उपलब्ध छैन।</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($photos->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $photos->links() }}
        </div>
    @endif
</div>
@endsection
<!-- Phot
o Modal -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800"></h3>
            <button onclick="closePhotoModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <img id="modalImage" class="w-full h-auto rounded-lg" src="" alt="">
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p id="modalDescription" class="text-gray-600 mb-2"></p>
                    <span id="modalCategory" class="inline-block bg-[#0073b7] text-white px-2 py-1 rounded text-xs font-medium"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Photo modal functionality
function openPhotoModal(imageUrl, title, description, category) {
    document.getElementById('photoModal').classList.remove('hidden');
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description || '';
    document.getElementById('modalCategory').textContent = category || '';
    document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.getElementById('modalImage').src = '';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePhotoModal();
    }
});
</script>