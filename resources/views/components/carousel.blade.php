<div class="relative w-full shadow-lg" data-carousel>
    <div class="relative h-96 w-full overflow-hidden">
        @if(isset($featuredNews) && $featuredNews->count() > 0)
            @foreach($featuredNews as $index => $article)
                <div data-slide class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h2 class="text-2xl font-bold mb-2">{{ $article->title }}</h2>
                        @if($article->excerpt)
                            <p class="text-sm opacity-90 line-clamp-2">{{ $article->excerpt }}</p>
                        @endif
                        <div class="flex items-center text-xs mt-2 opacity-75">
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
                        <a href="{{ route('news.show', $article->slug) }}" class="inline-block mt-3 bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                            पूरा पढ्नुहोस्
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            @foreach(config('site.carousel_images', []) as $index => $image)
                <div data-slide class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
                    <img src="{{ $image['url'] }}" alt="Slide {{ $index + 1 }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h2 class="text-2xl font-bold">{{ $image['title'] }}</h2>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="absolute top-0 left-0 bg-gradient-to-r from-[#0073b7] to-[#004a7f] text-white px-6 py-2 text-lg font-bold shadow-lg" style="clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%)"
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            समाचार
        </div>
        
        <button data-prev class="absolute top-1/2 left-2 -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full hover:bg-opacity-60 transition-opacity">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button data-next class="absolute top-1/2 right-2 -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full hover:bg-opacity-60 transition-opacity">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Dot indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            @if(isset($featuredNews) && $featuredNews->count() > 0)
                @foreach($featuredNews as $index => $article)
                    <button data-dot class="w-3 h-3 rounded-full transition-colors {{ $index === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }}"></button>
                @endforeach
            @else
                @foreach(config('site.carousel_images', []) as $index => $image)
                    <button data-dot class="w-3 h-3 rounded-full transition-colors {{ $index === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }}"></button>
                @endforeach
            @endif
        </div>
    </div>
    <a href="{{ route('home') }}" class="w-full bg-gradient-to-r from-[#0073b7] to-[#004a7f] text-white font-bold py-3 mt-2 flex items-center justify-center hover:from-[#004a7f] hover:to-[#003366] transition-all duration-200 shadow-md hover:shadow-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
        </svg>
        सबै समाचार हेर्नुहोस्
    </a>
</div>