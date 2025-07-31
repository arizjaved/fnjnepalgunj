@extends('layouts.admin')

@section('title', 'Edit About Page - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit About Page</h1>
            <p class="text-gray-600">Update the about page content and information</p>
        </div>
        <a href="{{ route('admin.about.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to About Page
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
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
                       value="{{ old('title', $aboutPage->title ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Enter page title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Main Content Paragraphs -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Main Content Paragraphs <span class="text-red-500">*</span>
                </label>
                <div id="main-content-container">
                    @if(old('main_content', $aboutPage->main_content ?? []))
                        @foreach(old('main_content', $aboutPage->main_content ?? []) as $index => $paragraph)
                            <div class="mb-3 paragraph-item">
                                <textarea name="main_content[]" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                          placeholder="Enter paragraph {{ $index + 1 }}"
                                          required>{{ $paragraph }}</textarea>
                                <button type="button" onclick="removeParagraph(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove Paragraph</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-3 paragraph-item">
                            <textarea name="main_content[]" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                      placeholder="Enter paragraph 1"
                                      required></textarea>
                            <button type="button" onclick="removeParagraph(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove Paragraph</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addParagraph()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Paragraph</button>
                @error('main_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Vision -->
            <div>
                <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">
                    Vision Statement
                </label>
                <textarea id="vision" 
                          name="vision" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('vision') border-red-500 @enderror"
                          placeholder="Enter vision statement">{{ old('vision', $aboutPage->vision ?? '') }}</textarea>
                @error('vision')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mission Points -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Mission Points
                </label>
                <div id="mission-container">
                    @if(old('mission', $aboutPage->mission ?? []))
                        @foreach(old('mission', $aboutPage->mission ?? []) as $index => $mission)
                            <div class="mb-2 mission-item">
                                <input type="text" 
                                       name="mission[]" 
                                       value="{{ $mission }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                       placeholder="Enter mission point {{ $index + 1 }}">
                                <button type="button" onclick="removeMission(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2 mission-item">
                            <input type="text" 
                                   name="mission[]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                   placeholder="Enter mission point 1">
                            <button type="button" onclick="removeMission(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addMission()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Mission Point</button>
            </div>

            <!-- Objectives -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Objectives
                </label>
                <div id="objectives-container">
                    @if(old('objectives', $aboutPage->objectives ?? []))
                        @foreach(old('objectives', $aboutPage->objectives ?? []) as $index => $objective)
                            <div class="mb-2 objective-item">
                                <input type="text" 
                                       name="objectives[]" 
                                       value="{{ $objective }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                       placeholder="Enter objective {{ $index + 1 }}">
                                <button type="button" onclick="removeObjective(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2 objective-item">
                            <input type="text" 
                                   name="objectives[]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                   placeholder="Enter objective 1">
                            <button type="button" onclick="removeObjective(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addObjective()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Objective</button>
            </div>

            <!-- Quick Facts -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Quick Facts (Sidebar)
                </label>
                <div id="facts-container">
                    @if(old('quick_facts', $aboutPage->quick_facts ?? []))
                        @foreach(old('quick_facts', $aboutPage->quick_facts ?? []) as $index => $fact)
                            <div class="mb-2 fact-item">
                                <input type="text" 
                                       name="quick_facts[]" 
                                       value="{{ $fact }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                       placeholder="Enter fact {{ $index + 1 }}">
                                <button type="button" onclick="removeFact(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2 fact-item">
                            <input type="text" 
                                   name="quick_facts[]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                   placeholder="Enter fact 1">
                            <button type="button" onclick="removeFact(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addFact()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Fact</button>
            </div>

            <!-- Leadership Positions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Leadership Positions (Sidebar)
                </label>
                <div id="positions-container">
                    @if(old('leadership_positions', $aboutPage->leadership_positions ?? []))
                        @foreach(old('leadership_positions', $aboutPage->leadership_positions ?? []) as $index => $position)
                            <div class="mb-2 position-item">
                                <input type="text" 
                                       name="leadership_positions[]" 
                                       value="{{ $position }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                       placeholder="Enter position {{ $index + 1 }}">
                                <button type="button" onclick="removePosition(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2 position-item">
                            <input type="text" 
                                   name="leadership_positions[]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                   placeholder="Enter position 1">
                            <button type="button" onclick="removePosition(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addPosition()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Position</button>
            </div> 
           <!-- Current Hero Image -->
            @if($aboutPage && $aboutPage->hero_image)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Current Hero Image</h4>
                    <img src="{{ $aboutPage->hero_image_url }}" alt="Current Hero Image" class="w-full h-48 object-cover rounded-lg border">
                </div>
            @endif

            <!-- Hero Image Upload -->
            <div>
                <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $aboutPage && $aboutPage->hero_image ? 'Replace Hero Image' : 'Hero Image' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="hero_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                                <span>Upload an image</span>
                                <input id="hero_image" name="hero_image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                @error('hero_image')
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
                    <option value="active" {{ old('status', $aboutPage->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $aboutPage->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.about.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                    Update About Page
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('hero_image');
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
    const fileInput = document.getElementById('hero_image');
    const dropZone = fileInput.closest('.border-dashed');
    fileInput.value = '';
    
    dropZone.querySelector('.text-center').innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
            <label for="hero_image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0073b7] hover:text-[#004a7f] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0073b7]">
                <span>Upload an image</span>
            </label>
            <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
    `;
}

// Dynamic form field functions
function addParagraph() {
    const container = document.getElementById('main-content-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-3 paragraph-item';
    div.innerHTML = `
        <textarea name="main_content[]" 
                  rows="3"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                  placeholder="Enter paragraph ${count}"
                  required></textarea>
        <button type="button" onclick="removeParagraph(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove Paragraph</button>
    `;
    container.appendChild(div);
}

function removeParagraph(button) {
    const container = document.getElementById('main-content-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    }
}

function addMission() {
    const container = document.getElementById('mission-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 mission-item';
    div.innerHTML = `
        <input type="text" 
               name="mission[]" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
               placeholder="Enter mission point ${count}">
        <button type="button" onclick="removeMission(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
    `;
    container.appendChild(div);
}

function removeMission(button) {
    button.parentElement.remove();
}

function addObjective() {
    const container = document.getElementById('objectives-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 objective-item';
    div.innerHTML = `
        <input type="text" 
               name="objectives[]" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
               placeholder="Enter objective ${count}">
        <button type="button" onclick="removeObjective(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
    `;
    container.appendChild(div);
}

function removeObjective(button) {
    button.parentElement.remove();
}

function addFact() {
    const container = document.getElementById('facts-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 fact-item';
    div.innerHTML = `
        <input type="text" 
               name="quick_facts[]" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
               placeholder="Enter fact ${count}">
        <button type="button" onclick="removeFact(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
    `;
    container.appendChild(div);
}

function removeFact(button) {
    button.parentElement.remove();
}

function addPosition() {
    const container = document.getElementById('positions-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2 position-item';
    div.innerHTML = `
        <input type="text" 
               name="leadership_positions[]" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
               placeholder="Enter position ${count}">
        <button type="button" onclick="removePosition(this)" class="mt-1 text-sm text-red-600 hover:text-red-800">Remove</button>
    `;
    container.appendChild(div);
}

function removePosition(button) {
    button.parentElement.remove();
}
</script>
@endsection