@extends('layouts.admin')

@section('title', 'Edit Committee Page - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Committee Page</h1>
            <p class="text-gray-600">Update the committee page content and information</p>
        </div>
        <a href="{{ route('admin.committee.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Committee Page
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.committee.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $committeeContent->title ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Enter page title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtitle -->
            <div>
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                    Subtitle
                </label>
                <input type="text" 
                       id="subtitle" 
                       name="subtitle" 
                       value="{{ old('subtitle', $committeeContent->subtitle ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('subtitle') border-red-500 @enderror"
                       placeholder="Enter page subtitle">
                @error('subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Enter page description">{{ old('description', $committeeContent->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Term Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Committee Term Information
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="term_period" class="block text-xs font-medium text-gray-600 mb-1">Term Period</label>
                        <input type="text" 
                               id="term_period" 
                               name="term_info[कार्यकाल]" 
                               value="{{ old('term_info.कार्यकाल', $committeeContent->term_info['कार्यकाल'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., २०८१-२०८३ (३ वर्ष)">
                    </div>
                    <div>
                        <label for="executive_members" class="block text-xs font-medium text-gray-600 mb-1">Executive Members</label>
                        <input type="text" 
                               id="executive_members" 
                               name="term_info[कार्यकारी सदस्य]" 
                               value="{{ old('term_info.कार्यकारी सदस्य', $committeeContent->term_info['कार्यकारी सदस्य'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., ८ जना">
                    </div>
                    <div>
                        <label for="election_date" class="block text-xs font-medium text-gray-600 mb-1">Election Date</label>
                        <input type="text" 
                               id="election_date" 
                               name="term_info[निर्वाचन मिति]" 
                               value="{{ old('term_info.निर्वाचन मिति', $committeeContent->term_info['निर्वाचन मिति'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., २०८१ चैत्र १५">
                    </div>
                </div>
            </div>

            <!-- Responsibilities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Main Responsibilities
                </label>
                <div id="responsibilities-container">
                    @if(old('responsibilities', $committeeContent->responsibilities ?? []))
                        @foreach(old('responsibilities', $committeeContent->responsibilities ?? []) as $index => $responsibility)
                            <div class="mb-2 responsibility-item">
                                <input type="text" 
                                       name="responsibilities[]" 
                                       value="{{ $responsibility }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                       placeholder="Enter responsibility {{ $index + 1 }}">
                                <button type="button" onclick="removeResponsibility(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2 responsibility-item">
                            <input type="text" 
                                   name="responsibilities[]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                   placeholder="Enter responsibility 1">
                            <button type="button" onclick="removeResponsibility(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addResponsibility()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Responsibility</button>
            </div>

            <!-- Section Titles -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Section Titles
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="executive_section_title" class="block text-xs font-medium text-gray-600 mb-1">Executive Committee Section Title</label>
                        <input type="text" 
                               id="executive_section_title" 
                               name="section_titles[executive_committee]" 
                               value="{{ old('section_titles.executive_committee', $committeeContent->section_titles['executive_committee'] ?? 'कार्यकारी समिति') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., कार्यकारी समिति">
                    </div>
                    <div>
                        <label for="central_section_title" class="block text-xs font-medium text-gray-600 mb-1">Central Members Section Title</label>
                        <input type="text" 
                               id="central_section_title" 
                               name="section_titles[central_committee]" 
                               value="{{ old('section_titles.central_committee', $committeeContent->section_titles['central_committee'] ?? 'केन्द्रीय सदस्यहरू') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., केन्द्रीय सदस्यहरू">
                    </div>
                    <div>
                        <label for="info_section_title" class="block text-xs font-medium text-gray-600 mb-1">Committee Information Section Title</label>
                        <input type="text" 
                               id="info_section_title" 
                               name="section_titles[committee_info]" 
                               value="{{ old('section_titles.committee_info', $committeeContent->section_titles['committee_info'] ?? 'समितिको जानकारी') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., समितिको जानकारी">
                    </div>
                    <div>
                        <label for="responsibilities_section_title" class="block text-xs font-medium text-gray-600 mb-1">Responsibilities Section Title</label>
                        <input type="text" 
                               id="responsibilities_section_title" 
                               name="section_titles[responsibilities]" 
                               value="{{ old('section_titles.responsibilities', $committeeContent->section_titles['responsibilities'] ?? 'मुख्य जिम्मेवारीहरू') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., मुख्य जिम्मेवारीहरू">
                    </div>
                    <div>
                        <label for="contact_section_title" class="block text-xs font-medium text-gray-600 mb-1">Contact Information Section Title</label>
                        <input type="text" 
                               id="contact_section_title" 
                               name="section_titles[contact_info]" 
                               value="{{ old('section_titles.contact_info', $committeeContent->section_titles['contact_info'] ?? 'सम्पर्क जानकारी') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., सम्पर्क जानकारी">
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Contact Information
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="contact_address" class="block text-xs font-medium text-gray-600 mb-1">Address</label>
                        <input type="text" 
                               id="contact_address" 
                               name="contact_address" 
                               value="{{ old('contact_address', $committeeContent->contact_info['address'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., काठमाडौं, नेपाल">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-xs font-medium text-gray-600 mb-1">Phone</label>
                        <input type="text" 
                               id="contact_phone" 
                               name="contact_phone" 
                               value="{{ old('contact_phone', $committeeContent->contact_info['phone'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., +977-1-4444444">
                    </div>
                    <div>
                        <label for="contact_email" class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_email" 
                               value="{{ old('contact_email', $committeeContent->contact_info['email'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                               placeholder="e.g., info@fnjnepal.org">
                    </div>
                </div>
            </div>      
      <!-- Current Banner Image -->
            @if($committeeContent && $committeeContent->banner_image)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Current Banner Image</h4>
                    <img src="{{ $committeeContent->banner_image_url }}" alt="Current Banner Image" class="w-full h-48 object-cover rounded-lg border">
                </div>
            @endif

            <!-- Banner Image Upload -->
            <div>
                <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $committeeContent && $committeeContent->banner_image ? 'Replace Banner Image' : 'Banner Image' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="banner_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                                <span>Upload an image</span>
                                <input id="banner_image" name="banner_image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                @error('banner_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                    <option value="active" {{ old('status', $committeeContent->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $committeeContent->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.committee.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                    Update Committee Page
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('banner_image');
    const dropZone = fileInput.closest('.border-dashed');
    
    // File input change handler
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            dropZone.querySelector('.text-center').innerHTML = `
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-gray-600"><strong>${fileName}</strong></p>
                <p class="text-xs text-gray-500">${fileSize} MB</p>
                <button type="button" onclick="clearFile()" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
            `;
        }
    });
    
    // Drag and drop handlers
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        dropZone.classList.add('border-[#0073b7]', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-[#0073b7]', 'bg-blue-50');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});

function clearFile() {
    const fileInput = document.getElementById('banner_image');
    const dropZone = fileInput.closest('.border-dashed');
    fileInput.value = '';
    
    dropZone.querySelector('.text-center').innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
            <label for="banner_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                <span>Upload an image</span>
            </label>
            <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
    `;
}

// Dynamic responsibilities functions
function addResponsibility() {
    const container = document.getElementById('responsibilities-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 responsibility-item';
    div.innerHTML = `
        <input type="text" 
               name="responsibilities[]" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
               placeholder="Enter responsibility ${count}">
        <button type="button" onclick="removeResponsibility(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
    `;
    container.appendChild(div);
}

function removeResponsibility(button) {
    button.parentElement.remove();
}
</script>
@endsection