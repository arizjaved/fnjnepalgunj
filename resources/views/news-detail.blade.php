@extends('layouts.app')

@section('title', $article->title . ' - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'समाचार विस्तार')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Article Content -->
    <div class="lg:col-span-2">
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Article Header -->
            <div class="relative">
                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-64 md:h-80 object-cover">
                <div class="absolute top-4 left-4">
                    <span class="bg-[#0073b7] text-white px-3 py-1 rounded-full text-sm font-medium">समाचार</span>
                </div>
            </div>
            
            <!-- Article Content -->
            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#004a7f] mb-4 leading-tight">{{ $article->title }}</h1>
                    
                    <!-- Article Meta -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $article->published_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $article->creator->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>{{ rand(500, 2000) }} पटक पढिएको</span>
                        </div>
                        @if($article->updated_at != $article->created_at && $article->updater)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>{{ $article->updater->name }} द्वारा अपडेट गरिएको</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Article Body -->
                <div class="prose prose-lg max-w-none">
                    @if($article->excerpt)
                        <div class="text-xl text-gray-700 mb-6 font-medium leading-relaxed">
                            {{ $article->excerpt }}
                        </div>
                    @endif
                    
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
                
                <!-- Social Share -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">साझा गर्नुहोस्:</h3>
                        <div class="flex space-x-3">
                            <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M.057 9.076c0-4.986 4.043-9.029 9.029-9.029s9.029 4.043 9.029 9.029c0 4.986-4.043 9.029-9.029 9.029s-9.029-4.043-9.029-9.029z"></path>
                                    <path fill="#fff" d="M13.684 9.076c0-2.543-2.062-4.605-4.605-4.605s-4.605 2.062-4.605 4.605 2.062 4.605 4.605 4.605 4.605-2.062 4.605-4.605z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        
        <!-- Related Articles -->
        @if($relatedNews->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                    </svg>
                    सम्बन्धित समाचारहरू
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($relatedNews as $related)
                        <div class="flex space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" class="w-16 h-16 object-cover rounded flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-800 line-clamp-2 hover:text-[#0073b7] transition-colors">
                                    <a href="{{ route('news.show', $related->slug) }}">{{ $related->title }}</a>
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $related->published_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Latest News -->
        @if($relatedNews->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ताजा समाचार
                </h3>
                
                <div class="space-y-3">
                    @foreach($relatedNews->take(5) as $latest)
                        <div class="border-b border-gray-100 pb-3 last:border-b-0">
                            <h4 class="text-sm font-medium text-gray-800 line-clamp-2 hover:text-[#0073b7] transition-colors mb-1">
                                <a href="{{ route('news.show', $latest->slug) }}">{{ $latest->title }}</a>
                            </h4>
                            <p class="text-xs text-gray-500">{{ $latest->published_at->format('Y-m-d') }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('news') }}" class="text-[#0073b7] hover:text-[#004a7f] text-sm font-medium flex items-center">
                        सबै समाचार हेर्नुहोस्
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Categories -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                श्रेणीहरू
            </h3>
            
            <div class="space-y-2">
                @php
                    $categories = ['संस्थागत समाचार', 'कार्यक्रम', 'तालिम', 'सम्मेलन', 'अभियान', 'कल्याण', 'सूचना'];
                @endphp
                
                @foreach($categories as $category)
                    <a href="{{ route('news') }}?category={{ urlencode($category) }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                द्रुत लिङ्कहरू
            </h3>
            
            <div class="space-y-2">
                <a href="{{ route('about') }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">हाम्रो बारेमा</a>
                <a href="{{ route('committee') }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">कार्यसमिति</a>
                <a href="{{ route('publications') }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">प्रकाशनहरू</a>
                <a href="{{ route('video-gallery') }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">भिडियो ग्यालरी</a>
                <a href="{{ route('contact') }}" class="block text-gray-600 hover:text-[#0073b7] text-sm p-2 rounded hover:bg-gray-50 transition-colors">सम्पर्क</a>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    max-width: none;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
@endsection