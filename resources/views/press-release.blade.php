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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path>
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
        @include('components.sidebar', ['pressReleases' => $pressReleases, 'notices' => $notices])
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