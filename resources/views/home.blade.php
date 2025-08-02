@extends('layouts.app')

@section('title', 'गृहपृष्ठ - नेपाल पत्रकार महासंघ')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @include('components.carousel')
</br>
            <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#004a7f] flex items-center">
                <svg class="w-6 h-6 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                | ताजा समाचार
            </h2>
            <a href="{{ route('news') }}" class="text-sm bg-[#0073b7]/10 text-[#004a7f] px-4 py-2 rounded-md hover:bg-[#0073b7] hover:text-white transition-colors font-medium">
                सबै समाचार हेर्नुहोस्
            </a>
        </div>
        
        @if($latestNews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestNews as $article)
                    <article class="group">
                        <a href="{{ route('news.show', $article->slug) }}" class="block">
                            <div class="relative overflow-hidden rounded-lg mb-3">
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-[#0073b7] text-white px-2 py-1 rounded text-xs font-medium">समाचार</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2 group-hover:text-[#0073b7] transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 100) }}</p>
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $article->published_at->format('Y-m-d') }}
                                <span class="mx-2">•</span>
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $article->creator->name }}
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">कुनै समाचार उपलब्ध छैन</h3>
                <p class="text-gray-500">हाल कुनै समाचार प्रकाशित गरिएको छैन।</p>
            </div>
        @endif
            </div>
        </div>
        
        <div>
            @include('components.sidebar')
        </div>
    </div>


    <!-- Photo and Video Gallery -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Photo Gallery -->
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    | फोटो ग्यालरी
                </h3>
                <a href="{{ route('photo-gallery') }}" class="text-sm bg-[#0073b7]/10 text-[#004a7f] px-3 py-1 rounded-md hover:bg-[#0073b7] hover:text-white transition-colors">View All</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @if($photoGallery->count() > 0)
                    @foreach($photoGallery as $photo)
                        <div class="group">
                            <a href="{{ route('photo-gallery') }}">
                                <div class="overflow-hidden rounded-md border">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->image_alt ?: $photo->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300" />
                                </div>
                                <p class="text-sm mt-2 text-gray-700">{{ $photo->title }}</p>
                            </a>
                        </div>
                    @endforeach
                @else
                    @foreach(array_slice(config('site.photo_gallery_items', []), 0, 4) as $item)
                        <div class="group">
                            <a href="{{ route('photo-gallery') }}">
                                <div class="overflow-hidden rounded-md border">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['caption'] }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300" />
                                </div>
                                <p class="text-sm mt-2 text-gray-700">{{ $item['caption'] }}</p>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Video Gallery -->
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    | भिडियो ग्यालरी
                </h3>
                <a href="{{ route('video-gallery') }}" class="text-sm bg-[#0073b7]/10 text-[#004a7f] px-3 py-1 rounded-md hover:bg-[#0073b7] hover:text-white transition-colors">सबै हेर्नुहोस्</a>
            </div>
            <div class="space-y-4">
                @if($videoGallery->count() > 0)
                    @foreach($videoGallery as $video)
                        <div class="group cursor-pointer" onclick="openVideoModal('{{ $video->embed_url }}', '{{ $video->title }}', '{{ $video->description ?: '' }}')">
                            <div class="flex space-x-3">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-24 h-16 object-cover rounded-md" />
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center rounded-md">
                                        <svg class="w-6 h-6 text-white opacity-70 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.647c1.295.742 1.295 2.545 0 3.286L7.279 20.99c-1.25.72-2.779-.217-2.779-1.643V5.653z"></path>
                                        </svg>
                                    </div>
                                    <!-- Duration -->
                                    @if($video->duration)
                                    <div class="absolute bottom-1 right-1 bg-black bg-opacity-75 text-white px-1 py-0.5 rounded text-xs">
                                        {{ $video->duration }}
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-800 group-hover:text-[#0073b7] transition-colors line-clamp-2">
                                        {{ $video->title }}
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <span class="bg-[#0073b7]/10 text-[#0073b7] px-2 py-0.5 rounded text-xs mr-2">भिडियो</span>
                                        <span>{{ $video->created_at->format('Y-m-d') }}</span>
                                        @if($video->views)
                                        <span class="mx-1">•</span>
                                        <span>{{ $video->views }} views</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach(array_slice(config('site.video_gallery_items', []), 0, 5) as $item)
                        <div class="group cursor-pointer" onclick="openVideoModal('{{ $item['url'] }}', '{{ $item['title'] }}', '{{ $item['description'] }}')">
                            <div class="flex space-x-3">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['title'] }}" class="w-24 h-16 object-cover rounded-md" />
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center rounded-md">
                                        <svg class="w-6 h-6 text-white opacity-70 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.647c1.295.742 1.295 2.545 0 3.286L7.279 20.99c-1.25.72-2.779-.217-2.779-1.643V5.653z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute bottom-1 right-1 bg-black bg-opacity-75 text-white px-1 py-0.5 rounded text-xs">
                                        {{ $item['duration'] }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-800 group-hover:text-[#0073b7] transition-colors line-clamp-2">
                                        {{ $item['title'] }}
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <span class="bg-[#0073b7]/10 text-[#0073b7] px-2 py-0.5 rounded text-xs mr-2">{{ $item['category'] }}</span>
                                        <span>{{ $item['date'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- View All Button -->
            <div class="pt-2">
                <a href="{{ route('video-gallery') }}" class="w-full bg-[#0073b7]/10 hover:bg-[#0073b7] text-[#0073b7] hover:text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    सबै भिडियो हेर्नुहोस्
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Sections -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Chairman's Message -->
        @if($chairmanSettings['enabled'])
        <div>
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    | अध्यक्षको सन्देश
                </h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                @if($chairmanSettings['photo'])
                <div class="flex items-start space-x-4 mb-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $chairmanSettings['photo']) }}" alt="{{ $chairmanSettings['name'] }}" class="w-20 h-20 rounded-full object-cover border-2 border-[#0073b7]">
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-[#004a7f] text-lg">{{ $chairmanSettings['name'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $chairmanSettings['position'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">नेपाल पत्रकार महासंघ</p>
                    </div>
                </div>
                @else
                <div class="text-center mb-4">
                    <h4 class="font-bold text-[#004a7f] text-lg">{{ $chairmanSettings['name'] }}</h4>
                    <p class="text-sm text-gray-600">{{ $chairmanSettings['position'] }}</p>
                    <p class="text-sm text-gray-500">नेपाल पत्रकार महासंघ</p>
                </div>
                @endif
                
                @if($chairmanSettings['message'])
                <div class="text-sm text-gray-700 leading-relaxed">
                    <p class="italic">"{{ $chairmanSettings['message'] }}"</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <!-- Fallback: Economic Activities -->
        <div>
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    | आर्थिक गतिविधि
                </h3>
                <a href="{{ route('economic-activity') }}" class="text-sm bg-[#0073b7]/10 text-[#004a7f] px-3 py-1 rounded-md hover:bg-[#0073b7] hover:text-white transition-colors">सबै हेर्नुहोस्</a>
            </div>
            <ul class="space-y-3">
                @foreach(array_slice(config('site.economic_activity_items', []), 0, 3) as $item)
                    <li class="border-b last:border-0 pb-3">
                        <a href="{{ $item['file'] }}" class="flex items-start text-gray-700 hover:text-[#0073b7] transition-colors">
                            <span class="mr-2 mt-1">&raquo;</span>
                            <span class="text-sm">{{ $item['title'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Facebook Section -->
        <div>
            <div class="border-b pb-2 mb-4">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                </svg>
                | Follow Us On Facebook
            </h3>
            </div>
            <div class="bg-gray-50 p-1 border rounded-md">
                @if($socialSettings['facebook_embed'])
                    {!! $socialSettings['facebook_embed'] !!}
                @else
                    <a href="#">
                        <img src="https://placehold.co/300x400/f0f2f5/3b5998/png?text=Facebook+Feed" alt="Facebook Page Placeholder" class="w-full h-auto"/>
                    </a>
                @endif
            </div>
        </div>

        <!-- Twitter Section -->
        <div>
            <div class="border-b pb-2 mb-4">
                <h3 class="text-xl font-bold text-[#004a7f] flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                </svg>
                | Follow Us On Twitter
            </h3>
            </div>
            <div class="p-2">
                @if($socialSettings['twitter_embed'])
                    {!! $socialSettings['twitter_embed'] !!}
                @else
                    <a class="twitter-timeline text-[#0073b7] hover:underline" href="#">Tweets by FNJNepal</a>
                    <div class="border rounded-lg p-4 mt-2 text-sm text-gray-600 bg-gray-50">
                        <p>Twitter feed is loading...</p>
                        <p class="mt-2 text-xs italic">(Twitter feed placeholder)</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
<!--
 Membership Status Modal -->
<div id="membershipModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">सदस्यता स्थिति जाँच गर्नुहोस्</h3>
            <button onclick="closeMembershipModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <form id="membershipStatusForm">
                <div class="mb-4">
                    <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">सदस्य ID</label>
                    <input type="text" id="member_id" name="member_id" required
                           placeholder="उदाहरण: FNJ-2025-000001"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                </div>
                <button type="submit" class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-2 px-4 rounded transition-colors">
                    स्थिति जाँच गर्नुहोस्
                </button>
            </form>
            
            <div id="membershipResult" class="mt-4 hidden">
                <div id="membershipStatus" class="p-4 rounded-lg"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Membership modal functionality
function openMembershipModal() {
    document.getElementById('membershipModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMembershipModal() {
    document.getElementById('membershipModal').classList.add('hidden');
    document.getElementById('membershipResult').classList.add('hidden');
    document.getElementById('membershipStatusForm').reset();
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('membershipModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMembershipModal();
    }
});

// Handle membership status form submission
document.getElementById('membershipStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const memberId = document.getElementById('member_id').value;
    const resultDiv = document.getElementById('membershipResult');
    const statusDiv = document.getElementById('membershipStatus');
    
    // Show loading state
    statusDiv.innerHTML = '<div class="text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#0073b7] mx-auto"></div><p class="mt-2 text-gray-600">जाँच गर्दै...</p></div>';
    resultDiv.classList.remove('hidden');
    
    // Make API call
    fetch('{{ route("membership.check-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ member_id: memberId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.found) {
            let statusClass = 'bg-green-100 border-green-400 text-green-700';
            if (data.status === 'pending') {
                statusClass = 'bg-yellow-100 border-yellow-400 text-yellow-700';
            } else if (data.status === 'rejected' || data.status === 'expired') {
                statusClass = 'bg-red-100 border-red-400 text-red-700';
            }
            
            let expiryInfo = '';
            if (data.expires_at && data.status === 'approved') {
                expiryInfo = `<p class="text-sm mt-2"><strong>म्याद सकिने मिति:</strong> ${data.expires_at}</p>`;
            }
            
            statusDiv.innerHTML = `
                <div class="border px-4 py-3 rounded ${statusClass}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p><strong>नाम:</strong> ${data.full_name}</p>
                            <p><strong>सदस्यता प्रकार:</strong> ${data.membership_type}</p>
                            <p><strong>स्थिति:</strong> ${data.message}</p>
                            ${expiryInfo}
                        </div>
                    </div>
                </div>
            `;
        } else {
            statusDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        ${data.message}
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        statusDiv.innerHTML = `
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    त्रुटि भयो। कृपया फेरि प्रयास गर्नुहोस्।
                </div>
            </div>
        `;
    });
});
</script>