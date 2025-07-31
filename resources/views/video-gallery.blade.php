@extends('layouts.app')

@section('title', 'भिडियो ग्यालरी - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'भिडियो ग्यालरी')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] rounded-lg p-8 text-white">
        <div class="flex items-center justify-center mb-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">भिडियो ग्यालरी</h1>
                <p class="text-xl opacity-90">नेपाल पत्रकार महासंघका कार्यक्रम र गतिविधिहरू</p>
            </div>
        </div>
        <div class="text-center">
            <p class="text-lg opacity-80">महासंघका विभिन्न कार्यक्रम, तालिम र सम्मेलनहरूका भिडियो संग्रह</p>
        </div>
    </div>

    <!-- Filter Buttons -->
    @if($categories->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    श्रेणी अनुसार छान्नुहोस्
                </h2>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('video-gallery') }}" class="px-4 py-2 {{ !request('category') ? 'bg-[#0073b7] text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-[#004a7f] hover:text-white transition-colors text-sm font-medium">
                        सबै ({{ $videos->total() }})
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('video-gallery', ['category' => $category->slug]) }}" class="px-4 py-2 {{ request('category') == $category->slug ? 'bg-[#0073b7] text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-[#004a7f] hover:text-white transition-colors text-sm">
                            {{ $category->name }} ({{ $category->video_galleries_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Video Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="video-grid">
        @forelse($videos as $video)
            <div class="video-item bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="relative group cursor-pointer" onclick="openVideoModal('{{ $video->embed_url }}', '{{ $video->title }}', '{{ $video->description }}')">
                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
                    
                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-16 h-16 bg-[#0073b7] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Duration Badge -->
                    @if($video->duration)
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded text-xs font-medium">
                            {{ $video->duration }}
                        </div>
                    @endif
                    
                    <!-- Category Badge -->
                    @if($video->category)
                        <div class="absolute top-2 left-2">
                            <span class="bg-[#0073b7] text-white px-2 py-1 rounded text-xs font-medium">{{ $video->category->name }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:text-[#0073b7] transition-colors cursor-pointer" onclick="openVideoModal('{{ $video->embed_url }}', '{{ $video->title }}', '{{ $video->description }}')">
                        {{ $video->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $video->description }}</p>
                    
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center space-x-3">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $video->created_at->format('Y-m-d') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $video->views }} हेराइ
                            </span>
                        </div>
                        <button class="text-[#0073b7] hover:text-[#004a7f] font-medium" onclick="openVideoModal('{{ $video->embed_url }}', '{{ $video->title }}', '{{ $video->description }}')">
                            हेर्नुहोस् →
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">कुनै भिडियो फेला परेन</h3>
                <p class="text-gray-500">यस श्रेणीमा कुनै भिडियो उपलब्ध छैन।</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($videos->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $videos->links() }}
        </div>
    @endif
</div>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800"></h3>
            <button onclick="closeVideoModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <div class="aspect-video mb-4">
                <iframe id="videoFrame" class="w-full h-full rounded-lg" src="" frameborder="0" allowfullscreen></iframe>
            </div>
            <p id="modalDescription" class="text-gray-600"></p>
        </div>
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const videoItems = document.querySelectorAll('.video-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update button styles
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-[#0073b7]', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-[#0073b7]', 'text-white');
            
            // Filter videos
            videoItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// Video modal functionality
function openVideoModal(url, title, description) {
    document.getElementById('videoModal').classList.remove('hidden');
    document.getElementById('videoFrame').src = url;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    document.getElementById('videoModal').classList.add('hidden');
    document.getElementById('videoFrame').src = '';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVideoModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-video {
    aspect-ratio: 16 / 9;
}
</style>
@endsection