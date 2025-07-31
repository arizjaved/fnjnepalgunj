@extends('layouts.app')

@section('title', 'उजुरी - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'उजुरी')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#0073b7]/10 rounded-full mb-4">
                <svg class="w-8 h-8 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-[#004a7f] mb-2">उजुरी गर्नुहोस्</h1>
            <p class="text-gray-600">तपाईंको उजुरी हाम्रो लागि महत्वपूर्ण छ। कृपया सबै आवश्यक जानकारी भर्नुहोस्।</p>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('grievance.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">पूरा नाम *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">इमेल ठेगाना *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">मोबाइल नम्बर</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">बिषय *</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('subject') border-red-500 @enderror" required>
                @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">उजुरीको विस्तृत विवरण *</label>
                <textarea id="message" name="message" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-[#0073b7] @error('message') border-red-500 @enderror" placeholder="कृपया आफ्नो उजुरीको विस्तृत विवरण लेख्नुहोस्..." required>{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-[#0073b7] text-white py-3 px-8 rounded-lg hover:bg-[#004a7f] transition-colors font-medium flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    उजुरी पेश गर्नुहोस्
                </button>
            </div>
        </form>
    </div>
</div>
@endsection