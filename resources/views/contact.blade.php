@extends('layouts.app')

@section('title', 'सम्पर्क - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'सम्पर्क')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#0073b7]/10 rounded-full mb-4">
                <svg class="w-8 h-8 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-[#004a7f] mb-2">सम्पर्क जानकारी</h1>
            <p class="text-gray-600">हामीसँग सम्पर्क गर्न निम्न माध्यमहरू प्रयोग गर्नुहोस्</p>
        </div>
        
        <div class="space-y-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-[#0073b7]/10 p-2 rounded-full">
                        <svg class="w-6 h-6 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">ठेगाना</h3>
                    <p class="text-gray-600">मिडिया भिलेज, तिलगंगा काठमाडौं</p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-[#004a7f]/10 p-2 rounded-full">
                        <svg class="w-6 h-6 text-[#004a7f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">फोन</h3>
                    <p class="text-gray-600">+९७७-१-५९१४७८५</p>
                    <p class="text-gray-600">+९७७-१-५९१४७२३</p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">इमेल</h3>
                    <p class="text-gray-600">fnjnepalcentral@gmail.com</p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-orange-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">कार्यालय समय</h3>
                    <p class="text-gray-600">आइतबार - शुक्रबार: १० बजे - ५ बजे</p>
                    <p class="text-gray-600">शनिबार: बन्द</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-[#004a7f]/10 rounded-full mb-3">
                <svg class="w-6 h-6 text-[#004a7f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-[#004a7f] mb-2">सन्देश पठाउनुहोस्</h2>
            <p class="text-gray-600">हामी तपाईंको प्रतिक्रियाको प्रतीक्षामा छौं</p>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-[#004a7f] mb-1">नाम *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-[#004a7f] mb-1">इमेल *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-[#004a7f] mb-1">फोन नम्बर</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-[#004a7f] mb-1">विषय *</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('subject') border-red-500 @enderror" required>
                @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-[#004a7f] mb-1">सन्देश *</label>
                <textarea id="message" name="message" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#0073b7] text-white py-3 px-4 rounded-lg hover:bg-[#004a7f] transition-colors font-medium flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                सन्देश पठाउनुहोस्
            </button>
        </form>
    </div>
</div>
@endsection