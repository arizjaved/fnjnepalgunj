@extends('layouts.admin')

@section('title', 'Site Settings - Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Site Settings</h1>
            <p class="text-gray-600">Manage your website configuration and settings</p>
        </div>
        <form method="POST" action="{{ route('admin.settings.seed') }}" class="inline">
            @csrf
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200"
                    onclick="return confirm('This will reset all settings to default values. Are you sure?')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset to Defaults
            </button>
        </form>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-8">
            @if($settings->isEmpty())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    <p>No settings found. Please run the seed command or click "Reset to Defaults" button above.</p>
                </div>
            @endif
            
            @foreach($settings as $group => $groupSettings)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 capitalize">
                            {{ ucfirst(str_replace('_', ' ', $group)) }} Settings
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($groupSettings as $setting)
                                <div class="{{ in_array($setting->type, ['textarea', 'image']) ? 'md:col-span-2' : '' }}">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $setting->label }}
                                        @if($setting->description)
                                            <span class="text-xs text-gray-500 block font-normal">{{ $setting->description }}</span>
                                        @endif
                                    </label>

                                    @if($setting->type === 'text' || $setting->type === 'email' || $setting->type === 'url')
                                        <input type="{{ $setting->type }}" 
                                               id="{{ $setting->key }}" 
                                               name="settings[{{ $setting->key }}]" 
                                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('settings.' . $setting->key) border-red-500 @enderror">
                                    
                                    @elseif($setting->type === 'color')
                                        <div class="flex items-center space-x-3">
                                            <input type="color" 
                                                   id="{{ $setting->key }}" 
                                                   name="settings[{{ $setting->key }}]" 
                                                   value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                   class="h-10 w-20 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('settings.' . $setting->key) border-red-500 @enderror">
                                            <input type="text" 
                                                   value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent"
                                                   readonly>
                                        </div>
                                    
                                    @elseif($setting->type === 'select')
                                        <select id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('settings.' . $setting->key) border-red-500 @enderror">
                                            @if($setting->key === 'font_family')
                                                <option value="Inter, system-ui, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Inter, system-ui, sans-serif' ? 'selected' : '' }}>Inter (Default)</option>
                                                <option value="Roboto, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                                <option value="Open Sans, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                                                <option value="Lato, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Lato, sans-serif' ? 'selected' : '' }}>Lato</option>
                                                <option value="Poppins, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                                <option value="Nunito, sans-serif" {{ old('settings.' . $setting->key, $setting->value) === 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                                            @endif
                                        </select>
                                    
                                    @elseif($setting->type === 'textarea')
                                        <textarea id="{{ $setting->key }}" 
                                                  name="settings[{{ $setting->key }}]" 
                                                  rows="4"
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('settings.' . $setting->key) border-red-500 @enderror">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                    
                                    @elseif($setting->type === 'json')
                                        <div class="space-y-2" id="json-{{ $setting->key }}">
                                            @php
                                                $jsonValue = is_string($setting->value) ? json_decode($setting->value, true) : $setting->value;
                                                $jsonValue = $jsonValue ?: [];
                                            @endphp
                                            @foreach($jsonValue as $index => $item)
                                                <div class="flex items-center space-x-2 json-item">
                                                    <input type="text" 
                                                           name="settings[{{ $setting->key }}][{{ $index }}][name]" 
                                                           value="{{ $item['name'] ?? '' }}"
                                                           placeholder="Link Name"
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                                                    <input type="text" 
                                                           name="settings[{{ $setting->key }}][{{ $index }}][url]" 
                                                           value="{{ $item['url'] ?? '' }}"
                                                           placeholder="URL"
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                                                    <button type="button" onclick="removeJsonItem(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Remove</button>
                                                </div>
                                            @endforeach
                                            <button type="button" onclick="addJsonItem('{{ $setting->key }}')" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Add Link</button>
                                        </div>
                                    
                                    @elseif($setting->type === 'boolean')
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="{{ $setting->key }}" 
                                                   name="settings[{{ $setting->key }}]" 
                                                   value="1"
                                                   {{ old('settings.' . $setting->key, $setting->value) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-[#0073b7] focus:ring-[#0073b7] border-gray-300 rounded">
                                            <label for="{{ $setting->key }}" class="ml-2 block text-sm text-gray-900">
                                                Enable {{ $setting->label }}
                                            </label>
                                        </div>
                                    
                                    @elseif($setting->type === 'image')
                                        @if($setting->value)
                                            <div class="mb-4">
                                                <img src="{{ asset('storage/' . $setting->value) }}" 
                                                     alt="{{ $setting->label }}" 
                                                     class="h-20 w-auto object-contain border border-gray-300 rounded">
                                            </div>
                                        @endif
                                        <input type="file" 
                                               id="{{ $setting->key }}" 
                                               name="settings[{{ $setting->key }}]" 
                                               accept="image/*"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('settings.' . $setting->key) border-red-500 @enderror">
                                    @endif

                                    @error('settings.' . $setting->key)
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-8">
            <button type="submit" 
                    class="px-8 py-3 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle file input previews
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Find existing preview or create new one
                    let preview = input.parentNode.querySelector('.file-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'file-preview mt-2';
                        input.parentNode.insertBefore(preview, input.nextSibling);
                    }
                    
                    if (file.type.startsWith('image/')) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="h-20 w-auto object-contain border border-gray-300 rounded">`;
                    } else {
                        preview.innerHTML = `<p class="text-sm text-gray-600">File selected: ${file.name}</p>`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Handle color picker sync
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(colorInput => {
        const textInput = colorInput.nextElementSibling;
        
        colorInput.addEventListener('change', function() {
            textInput.value = this.value;
        });
        
        textInput.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                colorInput.value = this.value;
            }
        });
    });
});

// JSON field management functions
function addJsonItem(fieldKey) {
    const container = document.getElementById(`json-${fieldKey}`);
    const items = container.querySelectorAll('.json-item');
    const newIndex = items.length;
    
    const newItem = document.createElement('div');
    newItem.className = 'flex items-center space-x-2 json-item';
    newItem.innerHTML = `
        <input type="text" 
               name="settings[${fieldKey}][${newIndex}][name]" 
               placeholder="Link Name"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
        <input type="text" 
               name="settings[${fieldKey}][${newIndex}][url]" 
               placeholder="URL"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
        <button type="button" onclick="removeJsonItem(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Remove</button>
    `;
    
    const addButton = container.querySelector('button[onclick*="addJsonItem"]');
    container.insertBefore(newItem, addButton);
}

function removeJsonItem(button) {
    button.parentElement.remove();
}
</script>
@endsection