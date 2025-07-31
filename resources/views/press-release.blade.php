@extends('layouts.app')

@section('title', 'प्रेस विज्ञप्ति - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'प्रेस विज्ञप्ति')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] text-white p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">प्रेस विज्ञप्ति</h1>
                </div>
                <p class="mt-2 text-white/80">नेपाल पत्रकार महासंघका आधिकारिक प्रेस विज्ञप्तिहरू</p>
            </div>

            <!-- Press Releases Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#0073b7] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">विषय</th>
                            <th class="px-6 py-4 text-center font-semibold">प्रकाशित मिति</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pressReleases as $release)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <a href="{{ route('press-release.show', $release->slug) }}" class="font-medium text-gray-900 hover:text-[#0073b7] transition-colors">
                                                {{ $release->title }}
                                            </a>
                                            @if($release->excerpt)
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $release->excerpt }}</p>
                                            @endif
                                            <div class="flex items-center mt-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#0073b7]/10 text-[#0073b7]">
                                                    प्रेस विज्ञप्ति
                                                </span>
                                                @if($release->featured_image)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        फोटो सहित
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $release->published_at->format('Y-m-d') }}</div>
                                    <div class="text-xs text-gray-500">{{ $release->creator->name }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">कुनै प्रेस विज्ञप्ति उपलब्ध छैन</h3>
                                        <p class="text-gray-500">हाल कुनै प्रेस विज्ञप्ति प्रकाशित गरिएको छैन।</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pressReleases->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $pressReleases->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Latest Press Releases -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="bg-[#0073b7] text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-4">
                <h3 class="font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                    </svg>
                    प्रेस विज्ञप्ति
                </h3>
                <div class="text-right">
                    <a href="#" class="text-xs text-white/80 hover:text-white">सबै हेर्नुहोस्</a>
                </div>
            </div>
            
            <div class="space-y-4">
                @foreach($pressReleases->take(5) as $release)
                    <div class="border-b border-gray-100 pb-3 last:border-b-0">
                        <a href="{{ route('press-release.show', $release->slug) }}" class="text-sm font-medium text-gray-800 hover:text-[#0073b7] transition-colors line-clamp-2 mb-1 block">
                            {{ $release->title }}
                        </a>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $release->published_at->format('Y-m-d') }}</span>
                            <span class="bg-[#0073b7]/10 text-[#0073b7] px-2 py-0.5 rounded">प्रेस विज्ञप्ति</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Notice Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="bg-[#0073b7] text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-4">
                <h3 class="font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    सूचना
                </h3>
                <div class="text-right">
                    <a href="{{ route('notice') }}" class="text-xs text-white/80 hover:text-white">सबै हेर्नुहोस्</a>
                </div>
            </div>
            
            <div class="space-y-3">
                @if($notices && $notices->count() > 0)
                    @foreach($notices as $notice)
                        <div class="border-b border-gray-100 pb-2 last:border-b-0">
                            <a href="{{ route('notice.show', $notice->slug) }}" class="text-sm font-medium text-gray-800 hover:text-[#0073b7] transition-colors line-clamp-2 block">
                                {{ $notice->title }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">{{ $notice->published_at->format('Y-m-d') }}</p>
                        </div>
                    @endforeach
                @else
                    @foreach(array_slice(config('site.notices_data', []), 0, 3) as $notice)
                        <div class="border-b border-gray-100 pb-2 last:border-b-0">
                            <h4 class="text-sm font-medium text-gray-800 hover:text-[#0073b7] transition-colors cursor-pointer line-clamp-2">
                                {{ $notice['title'] }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $notice['date'] }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Economic Activities -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="bg-[#0073b7] text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-4">
                <h3 class="font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    आर्थिक गतिविधि
                </h3>
            </div>
            
            <div class="space-y-2">
                @foreach(array_slice(config('site.economic_activity_items'), 0, 4) as $item)
                    <div class="text-sm">
                        <a href="{{ $item['file'] }}" class="text-gray-700 hover:text-[#0073b7] transition-colors line-clamp-2">
                            {{ $item['title'] }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">{{ $item['date'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Follow Us on Facebook -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="bg-[#0073b7] text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-4">
                <h3 class="font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                    Follow us on Facebook
                </h3>
            </div>
            
            <div class="text-center">
                <div class="bg-gray-100 rounded-lg p-4">
                    <div class="flex items-center justify-center mb-2">
                        <img src="https://placehold.co/50x50/0073b7/ffffff/png?text=FNJ" alt="FNJ" class="w-12 h-12 rounded-full">
                    </div>
                    <h4 class="font-semibold text-gray-800">Federation of Nepali Journalists</h4>
                    <p class="text-sm text-gray-600">14,074 followers</p>
                    <div class="mt-3 space-y-2">
                        <button class="w-full bg-[#1877f2] text-white py-2 px-4 rounded text-sm font-medium hover:bg-[#166fe5] transition-colors">
                            Follow Page
                        </button>
                        <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded text-sm font-medium hover:bg-gray-50 transition-colors">
                            Share
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-[#0073b7] text-sm hover:underline">Tweets by FNJNepal</a>
                </div>
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
</style>
@endsection