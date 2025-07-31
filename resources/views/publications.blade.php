@extends('layouts.app')

@section('title', 'प्रकाशन - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'प्रकाशन')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#0073b7]/10 rounded-full mb-4">
            <svg class="w-8 h-8 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-[#004a7f] mb-2">प्रकाशनहरू</h1>
        <p class="text-gray-600">महासंघका सबै प्रकाशनहरू यहाँ उपलब्ध छन्</p>
    </div>
    
    @if($publications->count() > 0)
        <div class="space-y-4">
            @foreach($publications as $publication)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $publication->title }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $publication->published_at ? $publication->published_at->format('Y-m-d') : $publication->created_at->format('Y-m-d') }}
                                </span>
                                @if($publication->document_size_formatted)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $publication->document_size_formatted }}
                                    </span>
                                @endif
                                @if($publication->document_type)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ strtoupper($publication->document_type) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('publications.download', $publication) }}" class="inline-flex items-center px-4 py-2 bg-[#0073b7] text-white rounded-lg hover:bg-[#004a7f] transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                डाउनलोड
                            </a>
                            <a href="{{ $publication->document_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#004a7f] text-white rounded-lg hover:bg-[#003366] transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                हेर्नुहोस्
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($publications->hasPages())
            <div class="mt-8">
                {{ $publications->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">कुनै प्रकाशन उपलब्ध छैन</h3>
            <p class="text-gray-500">हाल कुनै प्रकाशनहरू प्रकाशित गरिएको छैन।</p>
        </div>
    @endif
</div>
@endsection