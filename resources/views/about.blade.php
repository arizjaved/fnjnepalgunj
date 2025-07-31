@extends('layouts.app')

@section('title', 'हाम्रो बारेमा - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'हाम्रो बारेमा')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Main About Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-[#0073b7] rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">हाम्रो बारेमा</h1>
            </div>
            
            <div class="space-y-6 text-gray-700 leading-relaxed">
                @foreach($aboutData['main_content'] as $paragraph)
                    <p class="text-justify">{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>

        <!-- Vision & Mission Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <div class="w-8 h-8 bg-[#004a7f] rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                दृष्टिकोण र लक्ष्य
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-[#0073b7] to-[#004a7f] rounded-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-4">दृष्टिकोण</h3>
                    <p class="leading-relaxed">{{ $aboutData['vision_mission']['vision'] }}</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">मिशन</h3>
                    <ul class="space-y-2">
                        @foreach($aboutData['vision_mission']['mission'] as $mission)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $mission }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Objectives Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                मुख्य उद्देश्यहरू
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($aboutData['objectives'] as $index => $objective)
                    <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 bg-[#0073b7] text-white rounded-full flex items-center justify-center mr-3 flex-shrink-0 text-sm font-bold">
                            {{ $index + 1 }}
                        </div>
                        <span class="text-gray-700">{{ $objective }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Facts -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                {{ $aboutData['sidebar']['quick_facts']['title'] }}
            </h3>
            <ul class="space-y-3">
                @foreach($aboutData['sidebar']['quick_facts']['facts'] as $fact)
                    <li class="flex items-center text-sm text-gray-600 p-2 bg-gray-50 rounded">
                        <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $fact }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Leadership -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ $aboutData['sidebar']['leadership']['title'] }}
            </h3>
            <ul class="space-y-2">
                @foreach($aboutData['sidebar']['leadership']['positions'] as $position)
                    <li class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-[#004a7f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        {{ $position }}
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('committee') }}" class="inline-flex items-center text-[#0073b7] hover:text-[#004a7f] text-sm font-medium">
                    पूर्ण कार्यसमिति हेर्नुहोस्
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Important Links -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                महत्वपूर्ण लिङ्कहरू
            </h3>
            <div class="space-y-2">
                <a href="{{ route('committee') }}" class="block text-[#0073b7] hover:text-[#004a7f] text-sm p-2 rounded hover:bg-gray-50 transition-colors">कार्यसमिति</a>
                <a href="{{ route('publications') }}" class="block text-[#0073b7] hover:text-[#004a7f] text-sm p-2 rounded hover:bg-gray-50 transition-colors">प्रकाशनहरू</a>
                <a href="{{ route('economic-activity') }}" class="block text-[#0073b7] hover:text-[#004a7f] text-sm p-2 rounded hover:bg-gray-50 transition-colors">आर्थिक गतिविधि</a>
                <a href="{{ route('news') }}" class="block text-[#0073b7] hover:text-[#004a7f] text-sm p-2 rounded hover:bg-gray-50 transition-colors">समाचार</a>
                <a href="{{ route('contact.index') }}" class="block text-[#0073b7] hover:text-[#004a7f] text-sm p-2 rounded hover:bg-gray-50 transition-colors">सम्पर्क</a>
            </div>
        </div>
    </div>
</div>
@endsection