@extends('layouts.app')

@section('title', $pageContent->meta_title ?: ($pageContent->title . ' - नेपाल पत्रकार महासंघ'))
@section('meta_description', $pageContent->meta_description)
@section('breadcrumb', $pageContent->title)

@section('content')
<!-- Page Header -->
@if($pageContent->featured_image || $pageContent->subtitle || $pageContent->description)
    <div class="text-center mb-8">
        @if($pageContent->featured_image)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $pageContent->featured_image) }}" alt="{{ $pageContent->title }}" class="w-full max-w-4xl mx-auto rounded-lg shadow-lg">
            </div>
        @endif
        <h1 class="text-4xl font-bold text-[#004a7f] mb-2">{{ $pageContent->title }}</h1>
        @if($pageContent->subtitle)
            <p class="text-xl text-gray-700 mb-4">{{ $pageContent->subtitle }}</p>
        @endif
        @if($pageContent->description)
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">{{ $pageContent->description }}</p>
        @endif
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] text-white p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">सूचना सूची</h2>
                </div>
            </div>

            <!-- Notices Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#0073b7] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">विषय</th>
                            <th class="px-6 py-4 text-center font-semibold">प्रकाशित मिति</th>
                            <th class="px-6 py-4 text-center font-semibold">फाइल साइज</th>
                            <th class="px-6 py-4 text-center font-semibold">डाउनलोड गर्नुहोस्</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($notices as $notice)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">
                                                {{ $notice->title }}
                                            </div>
                                            @if($notice->document_name)
                                                <p class="text-sm text-gray-600 mt-1">{{ $notice->document_name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $notice->published_at->format('Y-m-d') }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-600">
                                        @if($notice->document_size)
                                            {{ $notice->document_size_formatted }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($notice->document_file)
                                        <a href="{{ route('notice.download', $notice->slug) }}" class="inline-flex items-center px-3 py-1 bg-[#0073b7] text-white text-sm font-medium rounded hover:bg-[#004a7f] transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            डाउनलोड
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">उपलब्ध छैन</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">कुनै सूचना फेला परेन</p>
                                    <p class="text-sm">हाल कुनै सूचना उपलब्ध छैन।</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($notices->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $notices->links() }}
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