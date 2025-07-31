@extends('layouts.app')

@section('title', $pressRelease->title . ' - नेपाल पत्रकार महासंघ')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-[#0073b7]">गृहपृष्ठ</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('press-release') }}" class="hover:text-[#0073b7]">प्रेस विज्ञप्ति</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ Str::limit($pressRelease->title, 50) }}</li>
        </ol>
    </nav>

    <!-- Press Release Content -->
    <article class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#0073b7] text-white">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    प्रेस विज्ञप्ति
                </span>
                <time class="text-sm text-gray-500">
                    {{ $pressRelease->published_at->format('Y-m-d') }}
                </time>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $pressRelease->title }}</h1>
            
            @if($pressRelease->excerpt)
                <p class="text-lg text-gray-600 leading-relaxed">{{ $pressRelease->excerpt }}</p>
            @endif
            
            <!-- Document Download Section -->
            @if($pressRelease->document_file)
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-[#0073b7] rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $pressRelease->document_name ?: 'Press Release Document' }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ strtoupper($pressRelease->document_type ?: 'Document') }}
                                    @if($pressRelease->document_size_formatted)
                                        • {{ $pressRelease->document_size_formatted }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('press-release.download', $pressRelease->slug) }}" 
                           class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>डाउनलोड गर्नुहोस्</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($pressRelease->content)) !!}
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>प्रकाशक: {{ $pressRelease->creator->name }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>प्रकाशित: {{ $pressRelease->published_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Press Releases -->
    @if($relatedPressReleases->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">अन्य प्रेस विज्ञप्तिहरू</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($relatedPressReleases as $related)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#0073b7] text-white">
                                    प्रेस विज्ञप्ति
                                </span>
                                <time class="text-xs text-gray-500">
                                    {{ $related->published_at->format('Y-m-d') }}
                                </time>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('press-release.show', $related->slug) }}" class="hover:text-[#0073b7] transition-colors">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            
                            @if($related->excerpt)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $related->excerpt }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <a href="{{ route('press-release.show', $related->slug) }}" 
                                   class="text-[#0073b7] hover:text-[#004a7f] text-sm font-medium transition-colors">
                                    पूरा पढ्नुहोस् →
                                </a>
                                @if($related->document_file)
                                    <span class="inline-flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        डकुमेन्ट उपलब्ध
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back to Press Releases -->
    <div class="mt-8 text-center">
        <a href="{{ route('press-release') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            सबै प्रेस विज्ञप्तिहरू हेर्नुहोस्
        </a>
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
    color: #374151;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1.25em;
}

.prose strong {
    color: #111827;
    font-weight: 600;
}
</style>
@endsection