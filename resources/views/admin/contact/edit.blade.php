@extends('layouts.admin')

@section('title', 'Edit Contact Page - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Contact Page</h1>
            <p class="text-gray-600">Update the contact page content and information</p>
        </div>
        <a href="{{ route('admin.contact-page.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Contact Page
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.contact-page.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Page Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $contactContent->title ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtitle
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $contactContent->subtitle ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('subtitle') border-red-500 @enderror">
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $contactContent->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea id="contact_address" 
                                  name="contact_address" 
                                  rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">{{ old('contact_address', $contactContent->contact_info['address'] ?? '') }}</textarea>
                    </div>
                    
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Primary Phone</label>
                        <input type="text" 
                               id="contact_phone" 
                               name="contact_phone" 
                               value="{{ old('contact_phone', $contactContent->contact_info['phone'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="contact_phone_secondary" class="block text-sm font-medium text-gray-700 mb-2">Secondary Phone</label>
                        <input type="text" 
                               id="contact_phone_secondary" 
                               name="contact_phone_secondary" 
                               value="{{ old('contact_phone_secondary', $contactContent->contact_info['phone_secondary'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               value="{{ old('contact_email', $contactContent->contact_info['email'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="contact_fax" class="block text-sm font-medium text-gray-700 mb-2">Fax</label>
                        <input type="text" 
                               id="contact_fax" 
                               name="contact_fax" 
                               value="{{ old('contact_fax', $contactContent->contact_info['fax'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Office Hours</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="office_weekdays" class="block text-sm font-medium text-gray-700 mb-2">Weekdays</label>
                        <input type="text" 
                               id="office_weekdays" 
                               name="office_weekdays" 
                               value="{{ old('office_weekdays', $contactContent->office_hours['weekdays'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., आइतबार - शुक्रबार: १० बजे - ५ बजे">
                    </div>
                    
                    <div>
                        <label for="office_saturday" class="block text-sm font-medium text-gray-700 mb-2">Saturday</label>
                        <input type="text" 
                               id="office_saturday" 
                               name="office_saturday" 
                               value="{{ old('office_saturday', $contactContent->office_hours['saturday'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., शनिबार: बन्द">
                    </div>
                    
                    <div>
                        <label for="office_holidays" class="block text-sm font-medium text-gray-700 mb-2">Holidays</label>
                        <input type="text" 
                               id="office_holidays" 
                               name="office_holidays" 
                               value="{{ old('office_holidays', $contactContent->office_hours['holidays'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., सार्वजनिक बिदाहरूमा बन्द">
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                        <input type="url" 
                               id="social_facebook" 
                               name="social_facebook" 
                               value="{{ old('social_facebook', $contactContent->social_links['facebook'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
                        <input type="url" 
                               id="social_twitter" 
                               name="social_twitter" 
                               value="{{ old('social_twitter', $contactContent->social_links['twitter'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="social_youtube" class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                        <input type="url" 
                               id="social_youtube" 
                               name="social_youtube" 
                               value="{{ old('social_youtube', $contactContent->social_links['youtube'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                        <input type="url" 
                               id="social_instagram" 
                               name="social_instagram" 
                               value="{{ old('social_instagram', $contactContent->social_links['instagram'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Map Embed -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Map Embed</h3>
                
                <div>
                    <label for="map_embed" class="block text-sm font-medium text-gray-700 mb-2">
                        Google Maps Embed Code
                    </label>
                    <textarea id="map_embed" 
                              name="map_embed" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                              placeholder="Paste your Google Maps embed iframe code here...">{{ old('map_embed', $contactContent->map_embed ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Get embed code from Google Maps by clicking Share > Embed a map</p>
                </div>
            </div>

            <!-- Banner Image -->
            <div class="border-b border-gray-200 pb-6">
                @if($contactContent && $contactContent->banner_image)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Current Banner Image</h4>
                        <img src="{{ $contactContent->banner_image_url }}" alt="Current Banner Image" class="w-full h-48 object-cover rounded-lg border">
                    </div>
                @endif

                <div>
                    <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $contactContent && $contactContent->banner_image ? 'Replace Banner Image' : 'Banner Image' }}
                    </label>
                    <input type="file" 
                           id="banner_image" 
                           name="banner_image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    @error('banner_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('status') border-red-500 @enderror"
                        required>
                    <option value="active" {{ old('status', $contactContent->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $contactContent->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.contact-page.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                    Update Contact Page
                </button>
            </div>
        </form>
    </div>
</div>
@endsection