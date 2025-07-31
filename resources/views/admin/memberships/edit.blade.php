@extends('layouts.admin')

@section('title', 'Edit Member - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">सदस्य सम्पादन गर्नुहोस्</h1>
            <p class="text-gray-600">सदस्यता रेकर्ड अपडेट गर्नुहोस्</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.memberships.show', $membership) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                हेर्नुहोस्
            </a>
            <a href="{{ route('admin.memberships.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                फिर्ता जानुहोस्
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.memberships.update', $membership) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">व्यक्तिगत जानकारी</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">पूरा नाम *</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $membership->full_name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="तपाईंको पूरा नाम लेख्नुहोस्">
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">इमेल ठेगाना *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $membership->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="example@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">फोन नम्बर *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $membership->phone) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="९८XXXXXXXX">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="citizenship_number" class="block text-sm font-medium text-gray-700 mb-2">नागरिकता नम्बर *</label>
                        <input type="text" id="citizenship_number" name="citizenship_number" value="{{ old('citizenship_number', $membership->citizenship_number) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="नागरिकता नम्बर">
                        @error('citizenship_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">जन्म मिति *</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $membership->date_of_birth ? $membership->date_of_birth->format('Y-m-d') : '') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">लिङ्ग *</label>
                        <select id="gender" name="gender" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="">लिङ्ग छान्नुहोस्</option>
                            <option value="male" {{ old('gender', $membership->gender) == 'male' ? 'selected' : '' }}>पुरुष</option>
                            <option value="female" {{ old('gender', $membership->gender) == 'female' ? 'selected' : '' }}>महिला</option>
                            <option value="other" {{ old('gender', $membership->gender) == 'other' ? 'selected' : '' }}>अन्य</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">ठेगाना *</label>
                    <textarea id="address" name="address" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                              placeholder="तपाईंको पूरा ठेगाना लेख्नुहोस्">{{ old('address', $membership->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Professional Information -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">व्यावसायिक जानकारी</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">शिक्षा *</label>
                        <input type="text" id="education" name="education" value="{{ old('education', $membership->education) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="तपाईंको शैक्षिक योग्यता">
                        @error('education')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">अनुभव (वर्षमा) *</label>
                        <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $membership->experience_years) }}" required min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="पत्रकारितामा अनुभव">
                        @error('experience_years')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="current_workplace" class="block text-sm font-medium text-gray-700 mb-2">हालको कार्यक्षेत्र *</label>
                        <input type="text" id="current_workplace" name="current_workplace" value="{{ old('current_workplace', $membership->current_workplace) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="हाल काम गरिरहेको संस्था">
                        @error('current_workplace')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">पद *</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $membership->position) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="तपाईंको पद">
                        @error('position')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Membership Details -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">सदस्यता विवरण</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="membership_type" class="block text-sm font-medium text-gray-700 mb-2">सदस्यता प्रकार *</label>
                        <select id="membership_type" name="membership_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="">प्रकार छान्नुहोस्</option>
                            <option value="associate" {{ old('membership_type', $membership->membership_type) == 'associate' ? 'selected' : '' }}>सहयोगी सदस्य</option>
                            <option value="regular" {{ old('membership_type', $membership->membership_type) == 'regular' ? 'selected' : '' }}>नियमित सदस्य</option>
                            <option value="life" {{ old('membership_type', $membership->membership_type) == 'life' ? 'selected' : '' }}>आजीवन सदस्य</option>
                        </select>
                        @error('membership_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">स्थिति *</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="pending" {{ old('status', $membership->status) == 'pending' ? 'selected' : '' }}>समीक्षाधीन</option>
                            <option value="approved" {{ old('status', $membership->status) == 'approved' ? 'selected' : '' }}>स्वीकृत</option>
                            <option value="rejected" {{ old('status', $membership->status) == 'rejected' ? 'selected' : '' }}>अस्वीकृत</option>
                            <option value="inactive" {{ old('status', $membership->status) == 'inactive' ? 'selected' : '' }}>निष्क्रिय</option>
                            <option value="expired" {{ old('status', $membership->status) == 'expired' ? 'selected' : '' }}>म्याद सकिएको</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">श्रेणी</label>
                        <select id="category_id" name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="">श्रेणी छान्नुहोस्</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $membership->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">म्याद सकिने मिति</label>
                        <input type="date" id="expires_at" name="expires_at" value="{{ old('expires_at', $membership->expires_at ? $membership->expires_at->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        @error('expires_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">आजीवन सदस्यताका लागि खाली छोड्नुहोस्</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_executive_committee" name="is_executive_committee" value="1" {{ old('is_executive_committee', $membership->is_executive_committee) ? 'checked' : '' }}
                               class="h-4 w-4 text-[#0073b7] focus:ring-[#0073b7] border-gray-300 rounded">
                        <label for="is_executive_committee" class="ml-2 block text-sm font-medium text-gray-700">
                            कार्यकारी समितिको सदस्य हो?
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">यदि यो सदस्य कार्यकारी समितिमा छ भने चेक गर्नुहोस्</p>
                    @error('is_executive_committee')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                @if($membership->status == 'rejected')
                <div class="mt-6">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">अस्वीकारको कारण</label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                              placeholder="अस्वीकारको कारण लेख्नुहोस्">{{ old('rejection_reason', $membership->rejection_reason) }}</textarea>
                    @error('rejection_reason')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            <!-- Current Files Display -->
            @if($membership->photo_path || $membership->citizenship_copy_path || $membership->experience_certificate_path)
            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">हालका कागजातहरू</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if($membership->photo_path)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">फोटो</p>
                        <img src="{{ $membership->photo_url }}" alt="Member Photo" class="w-32 h-32 object-cover rounded-lg mx-auto border">
                    </div>
                    @endif
                    
                    @if($membership->citizenship_copy_path)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">नागरिकताको प्रतिलिपि</p>
                        <a href="{{ $membership->citizenship_copy_url }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            हेर्नुहोस्
                        </a>
                    </div>
                    @endif
                    
                    @if($membership->experience_certificate_path)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">अनुभव प्रमाणपत्र</p>
                        <a href="{{ $membership->experience_certificate_url }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            हेर्नुहोस्
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- File Uploads -->
            <div class="border-l-4 border-[#0073b7] pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">नयाँ कागजातहरू अपलोड गर्नुहोस्</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">{{ $membership->photo_path ? 'नयाँ फोटो' : 'फोटो' }}</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">पासपोर्ट साइजको फोटो अपलोड गर्नुहोस्</p>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="citizenship_copy" class="block text-sm font-medium text-gray-700 mb-2">{{ $membership->citizenship_copy_path ? 'नयाँ नागरिकताको प्रतिलिपि' : 'नागरिकताको प्रतिलिपि' }}</label>
                        <input type="file" id="citizenship_copy" name="citizenship_copy" accept=".pdf,image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">नागरिकताको स्पष्ट प्रतिलिपि</p>
                        @error('citizenship_copy')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="experience_certificate" class="block text-sm font-medium text-gray-700 mb-2">{{ $membership->experience_certificate_path ? 'नयाँ अनुभव प्रमाणपत्र' : 'अनुभव प्रमाणपत्र' }}</label>
                        <input type="file" id="experience_certificate" name="experience_certificate" accept=".pdf,image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">पत्रकारितामा अनुभवको प्रमाणपत्र</p>
                        @error('experience_certificate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.memberships.show', $membership) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                    रद्द गर्नुहोस्
                </a>
                <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg transition-colors">
                    अपडेट गर्नुहोस्
                </button>
            </div>
        </form>
    </div>
</div>
@endsection