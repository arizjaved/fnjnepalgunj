@extends('layouts.app')

@section('title', 'समाचार - नेपाल पत्रकार महासंघ')
@section('meta_description', 'नेपाल पत्रकार महासंघका नवीनतम समाचार र घटनाहरू')
@section('breadcrumb', 'समाचार')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#0073b7]/10 rounded-full mb-4">
            <svg class="w-8 h-8 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-[#004a7f] mb-2">
            {{ $pageContent->title ?? 'समाचार' }}
        </h1>
        @if($pageContent->subtitle)
            <p class="text-xl text-gray-700 mb-4">
                {{ $pageContent->subtitle }}
            </p>
        @endif
    </div>

    <!-- Search Bar -->
    <div class="max-w-md mx-auto">
        <form method="GET" action="{{ route('news') }}" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="समाचार खोज्नुहोस्..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            @if(request('search'))
                <a href="{{ route('news') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>
        @if(request('search'))
            <p class="text-sm text-gray-600 mt-2 text-center">
                "{{ request('search') }}" को लागि {{ $news->total() }} परिणामहरू
            </p>
        @endif
    </div>

    <!-- Latest News (Featured) -->
    @if($news->count() > 0)
        @php $latestNews = $news->take(2); @endphp
        <div class="bg-gradient-to-r from-[#0073b7]/5 to-[#004a7f]/5 rounded-lg p-6">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-[#004a7f]">
                    नवीनतम समाचार
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($latestNews as $article)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-[#0073b7] text-white px-3 py-1 rounded-full text-sm font-medium">समाचार</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#004a7f] mb-2 hover:text-[#0073b7] transition-colors">
                                <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 150) }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $article->published_at->format('Y-m-d') }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $article->creator->name }}
                                    </span>
                                </div>
                                <a href="{{ route('news.show', $article->slug) }}" class="text-[#0073b7] hover:text-[#004a7f] font-medium">
                                    पूरा पढ्नुहोस् →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All News -->
    @if($news->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#004a7f] flex items-center">
                    <svg class="w-6 h-6 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                    </svg>
                    सबै समाचार ({{ $news->total() }})
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $article)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-40 object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="bg-[#004a7f] text-white px-2 py-1 rounded text-xs font-medium">समाचार</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-[#004a7f] mb-2 hover:text-[#0073b7] transition-colors line-clamp-2">
                                <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 100) }}</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $article->published_at->format('Y-m-d') }}
                                </span>
                                <a href="{{ route('news.show', $article->slug) }}" class="text-[#0073b7] hover:text-[#004a7f] font-medium">
                                    पढ्नुहोस् →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
            <div class="flex justify-center">
                {{ $news->links() }}
            </div>
        @endif
    @else
        <!-- No News Found -->
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                कुनै समाचार फेला परेन
            </h3>
            <p class="text-gray-500">
                @if(request('search'))
                    "{{ request('search') }}" को लागि कुनै समाचार फेला परेन।
                @else
                    हाल कुनै समाचार उपलब्ध छैन।
                @endif
            </p>
            @if(request('search'))
                <a href="{{ route('news') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-[#0073b7] text-white rounded-lg hover:bg-[#004a7f] transition-colors">
                    सबै समाचार हेर्नुहोस्
                </a>
            @endif
        </div>
    @endif
</div>
@endsection