@extends('layouts.app')

@section('title', 'कार्यसमिति - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'कार्यसमिति')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] rounded-lg p-8 text-white">
        <div class="flex items-center justify-center mb-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">{{ $committeeContent->title }}</h1>
                <p class="text-xl opacity-90">{{ $committeeContent->subtitle }}</p>
            </div>
        </div>
        <div class="text-center">
            <p class="text-lg opacity-80">{{ $committeeContent->description }}</p>
        </div>
    </div>

    <!-- Executive Committee -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            {{ $committeeContent->section_titles['executive_committee'] ?? 'कार्यकारी समिति' }}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($executiveCommittee as $member)
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 hover:shadow-lg transition-all duration-300 border border-gray-200">
                    <div class="text-center">
                        <div class="relative mb-4">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-24 h-28 mx-auto rounded-lg object-cover shadow-md">
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                <span class="bg-[#0073b7] text-white text-xs px-3 py-1 rounded-full font-medium">
                                    {{ $member['title'] }}
                                </span>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 mt-4">{{ $member['name'] }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ $member['bio'] }}</p>
                        <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs text-gray-500">{{ $member['contact'] }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">कार्यकारी समितिका सदस्यहरू छैनन्।</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Central Members -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <div class="w-8 h-8 bg-[#004a7f] rounded-lg flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            {{ $committeeContent->section_titles['central_committee'] ?? 'केन्द्रीय सदस्यहरू' }}
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($centralCommittee as $member)
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition-all duration-300 hover:bg-gray-100">
                    <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-20 h-24 mx-auto mb-4 rounded-lg object-cover shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">{{ $member['name'] }}</h3>
                    <p class="text-xs text-[#0073b7] font-medium mb-2">{{ $member['title'] }}</p>
                    <p class="text-xs text-gray-600 mb-3">{{ $member['bio'] }}</p>
                    <div class="flex items-center justify-center">
                        <svg class="w-3 h-3 text-[#0073b7] mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs text-gray-500">{{ $member['contact'] }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">केन्द्रीय सदस्यहरू छैनन्।</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Committee Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                {{ $committeeContent->section_titles['committee_info'] ?? 'समितिको जानकारी' }}
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                @if(is_array($committeeContent->term_info) && count($committeeContent->term_info) > 0)
                    @foreach($committeeContent->term_info as $key => $value)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="font-medium">{{ $key }}:</span>
                            <span>{{ $value }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="font-medium">कार्यकाल:</span>
                        <span>२०८१-२०८३ (३ वर्ष)</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="font-medium">कुल सदस्य संख्या:</span>
                        <span>{{ count($executiveCommittee) + count($centralCommittee) }} जना</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="font-medium">कार्यकारी सदस्य:</span>
                        <span>{{ count($executiveCommittee) }} जना</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="font-medium">केन्द्रीय सदस्य:</span>
                        <span>{{ count($centralCommittee) }} जना</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium">निर्वाचन मिति:</span>
                        <span>२०८१ चैत्र १५</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                </svg>
                {{ $committeeContent->section_titles['responsibilities'] ?? 'मुख्य जिम्मेवारीहरू' }}
            </h3>
            <ul class="space-y-2 text-sm text-gray-600">
                @if(is_array($committeeContent->responsibilities) && count($committeeContent->responsibilities) > 0)
                    @foreach($committeeContent->responsibilities as $responsibility)
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $responsibility }}
                        </li>
                    @endforeach
                @else
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        महासंघको नीति निर्माण र कार्यान्वयन
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        पत्रकारहरूको हक हितको संरक्षण
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        प्रेस स्वतन्त्रताको रक्षा र प्रवर्द्धन
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        पत्रकारिताको व्यावसायिक विकास
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        शाखा संगठनहरूको समन्वय र निर्देशन
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        अन्तर्राष्ट्रिय सम्बन्ध र सहकार्य
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] rounded-lg p-6 text-white">
        <div class="text-center">
            <h3 class="text-xl font-bold mb-4">{{ $committeeContent->section_titles['contact_info'] ?? 'सम्पर्क जानकारी' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                @if(is_array($committeeContent->contact_info) && count(array_filter($committeeContent->contact_info)) > 0)
                    @if($committeeContent->contact_info['address'])
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $committeeContent->contact_info['address'] }}</span>
                        </div>
                    @endif
                    @if($committeeContent->contact_info['phone'])
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ $committeeContent->contact_info['phone'] }}</span>
                        </div>
                    @endif
                    @if($committeeContent->contact_info['email'])
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $committeeContent->contact_info['email'] }}</span>
                        </div>
                    @endif
                @else
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>काठमाडौं, नेपाल</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+977-1-4444444</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>info@fnjnepal.org</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection