@extends('layouts.app')

@section('title', 'सदस्यता फारम - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'सदस्यता फारम')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] rounded-lg p-8 text-white mb-8">
        <div class="flex items-center justify-center mb-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">
                    {{ $pageContent->title ?? 'सदस्यता फारम' }}
                </h1>
                <p class="text-xl opacity-90">
                    {{ $pageContent->subtitle ?? 'नेपाल पत्रकार महासंघ' }}
                </p>
            </div>
        </div>
        <div class="text-center">
            <p class="text-lg opacity-80">
                {{ $pageContent->description ?? 'नेपाल पत्रकार महासंघको सदस्यता लिनका लागि तलको फारम भर्नुहोस्' }}
            </p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Membership Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-[#004a7f] mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            सदस्यताका प्रकारहरू
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $membershipTypes = [
                    'regular' => [
                        'title' => 'नियमित सदस्यता',
                        'features' => [
                            'न्यूनतम २ वर्षको पत्रकारिता अनुभव',
                            'वार्षिक शुल्क: रु. ५००',
                            'मतदानको अधिकार',
                            'सबै सुविधाहरूको पहुँच'
                        ]
                    ],
                    'associate' => [
                        'title' => 'सहयोगी सदस्यता',
                        'features' => [
                            'नयाँ पत्रकारहरूका लागि',
                            'वार्षिक शुल्क: रु. ३००',
                            'तालिम र कार्यशालामा सहभागिता',
                            'सीमित सुविधाहरू'
                        ]
                    ],
                    'life' => [
                        'title' => 'आजीवन सदस्यता',
                        'features' => [
                            '१० वर्षभन्दा बढी अनुभव',
                            'एकपटकको शुल्क: रु. १०,०००',
                            'सबै अधिकार र सुविधाहरू',
                            'विशेष सम्मान र पहिचान'
                        ]
                    ]
                ];
            @endphp
            
            @foreach($membershipTypes as $type => $details)
                <div class="border border-[#0073b7]/20 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <h3 class="font-bold text-[#0073b7] mb-2">{{ $details['title'] }}</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        @foreach($details['features'] as $feature)
                            <li>• {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Membership Form -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-[#004a7f] mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            सदस्यता आवेदन फारम
        </h2>

        <form action="{{ route('membership.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Personal Information -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">व्यक्तिगत जानकारी</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">पूरा नाम *</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">इमेल ठेगाना *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">फोन नम्बर *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="citizenship_number" class="block text-sm font-medium text-gray-700 mb-2">नागरिकता नम्बर *</label>
                        <input type="text" id="citizenship_number" name="citizenship_number" value="{{ old('citizenship_number') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('citizenship_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">जन्म मिति *</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">लिङ्ग *</label>
                        <select id="gender" name="gender" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="">छान्नुहोस्</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>पुरुष</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>महिला</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>अन्य</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">ठेगाना *</label>
                    <textarea id="address" name="address" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Educational and Professional Information -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">शैक्षिक र व्यावसायिक जानकारी</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">शैक्षिक योग्यता *</label>
                        <input type="text" id="education" name="education" value="{{ old('education') }}" required
                               placeholder="उदाहरण: स्नातक, पत्रकारितामा डिप्लोमा"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('education')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">पत्रकारितामा अनुभव (वर्षमा) *</label>
                        <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years') }}" required min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('experience_years')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="current_workplace" class="block text-sm font-medium text-gray-700 mb-2">हालको कार्यक्षेत्र *</label>
                        <input type="text" id="current_workplace" name="current_workplace" value="{{ old('current_workplace') }}" required
                               placeholder="उदाहरण: कान्तिपुर दैनिक, नेपाल टेलिभिजन"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('current_workplace')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">पद *</label>
                        <input type="text" id="position" name="position" value="{{ old('position') }}" required
                               placeholder="उदाहरण: संवाददाता, सम्पादक, फोटो पत्रकार"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('position')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Membership Type -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">सदस्यताको प्रकार</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="membership_type" value="associate" {{ old('membership_type') == 'associate' ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0073b7] border-gray-300 focus:ring-[#0073b7]">
                        <span class="ml-2 text-sm font-medium text-gray-700">सहयोगी सदस्यता (रु. ३००)</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="membership_type" value="regular" {{ old('membership_type') == 'regular' ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0073b7] border-gray-300 focus:ring-[#0073b7]">
                        <span class="ml-2 text-sm font-medium text-gray-700">नियमित सदस्यता (रु. ५००)</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="membership_type" value="life" {{ old('membership_type') == 'life' ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0073b7] border-gray-300 focus:ring-[#0073b7]">
                        <span class="ml-2 text-sm font-medium text-gray-700">आजीवन सदस्यता (रु. १०,०००)</span>
                    </label>
                </div>
                @error('membership_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Uploads -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">आवश्यक कागजातहरू</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">पासपोर्ट साइजको फोटो</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG फाइल मात्र (अधिकतम 2MB)</p>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="citizenship_copy" class="block text-sm font-medium text-gray-700 mb-2">नागरिकताको प्रतिलिपि</label>
                        <input type="file" id="citizenship_copy" name="citizenship_copy" accept=".pdf,image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG फाइल मात्र (अधिकतम 2MB)</p>
                        @error('citizenship_copy')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="experience_certificate" class="block text-sm font-medium text-gray-700 mb-2">कार्य अनुभव प्रमाणपत्र</label>
                        <input type="file" id="experience_certificate" name="experience_certificate" accept=".pdf,image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG फाइल मात्र (अधिकतम 2MB)</p>
                        @error('experience_certificate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required
                           class="w-4 h-4 text-[#0073b7] border-gray-300 rounded focus:ring-[#0073b7] mt-1">
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        म नेपाल पत्रकार महासंघको <a href="#" class="text-[#0073b7] hover:underline">नियम र सर्तहरू</a> र 
                        <a href="#" class="text-[#0073b7] hover:underline">आचारसंहिता</a> मान्न सहमत छु। *
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-6">
                <button type="submit" 
                        class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-8 rounded-lg transition-colors shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    आवेदन पेश गर्नुहोस्
                </button>
            </div>
        </form>
    </div>

    <!-- Contact Information -->
    <div class="bg-gradient-to-r from-[#0073b7] to-[#004a7f] rounded-lg p-6 text-white mt-8">
        <h3 class="text-xl font-bold mb-4 text-center">
            सम्पर्क जानकारी
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            @php
                $contactInfo = [
                    'address' => 'मिडिया भिलेज, तिलगंगा, काठमाडौं',
                    'phone' => '+९७७-१-५९१४७८५, ५९१४७२३',
                    'email' => 'fnjnepalcentral@gmail.com'
                ];
            @endphp
            
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $contactInfo['address'] }}</span>
            </div>
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span>{{ $contactInfo['phone'] }}</span>
            </div>
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $contactInfo['email'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection