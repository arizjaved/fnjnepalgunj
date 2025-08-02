@extends('layouts.admin')

@section('title', 'Site Settings - Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Enhanced Page Header -->
    <div class="bg-gradient-to-r from-[#0073b7] via-[#004a7f] to-[#003366] rounded-xl p-8 text-white mb-8 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="relative flex items-center justify-between">
            <div>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Site Settings</h1>
                        <p class="text-white/80 text-lg">Manage your website configuration and settings</p>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-white/70">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-white">Site Settings</span>
                </nav>
            </div>
            
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('admin.settings.seed') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium rounded-lg transition-all duration-200 border border-white/30"
                            onclick="return confirm('This will reset all settings to default values. Are you sure?')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset to Defaults
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Settings Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Settings Navigation">
                @php
                    $availableGroups = $settings->keys()->toArray();
                    $tabConfig = [
                        'brand' => ['label' => 'Brand & Identity', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z'],
                        'footer' => ['label' => 'Footer', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        'social' => ['label' => 'Social Media', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                        'seo' => ['label' => 'SEO & Analytics', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                        'functionality' => ['label' => 'Functionality', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z']
                    ];
                    $firstGroup = $availableGroups[0] ?? 'brand';
                @endphp
                
                @foreach($availableGroups as $index => $group)
                    @if(isset($tabConfig[$group]))
                        <button onclick="showSettingsTab('{{ $group }}')" class="settings-tab-btn {{ $index === 0 ? 'active border-[#0073b7] text-[#0073b7]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 border-b-2 font-medium text-sm">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tabConfig[$group]['icon'] }}"></path>
                            </svg>
                            {{ $tabConfig[$group]['label'] }}
                        </button>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if($settings->isEmpty())
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-8">
                <p>No settings found. Please run the seed command or click "Reset to Defaults" button above.</p>
            </div>
        @endif

        @foreach($settings as $group => $groupSettings)
            @php
                $groupConfig = [
                    'brand' => ['title' => 'Brand & Identity Settings', 'description' => 'Customize your website branding and visual identity', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z'],
                    'footer' => ['title' => 'Footer Settings', 'description' => 'Configure footer content and contact information', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    'social' => ['title' => 'Social Media Settings', 'description' => 'Configure social media integration and links', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    'seo' => ['title' => 'SEO & Analytics Settings', 'description' => 'Search engine optimization and analytics configuration', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                    'functionality' => ['title' => 'Functionality Settings', 'description' => 'Advanced configuration options and technical settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z']
                ];
                $config = $groupConfig[$group] ?? ['title' => ucfirst(str_replace('_', ' ', $group)) . ' Settings', 'description' => 'Configure ' . str_replace('_', ' ', $group) . ' settings', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4'];
                $isFirst = $loop->first;
            @endphp
            
            <div id="{{ $group }}-tab" class="settings-tab-content {{ $isFirst ? '' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                            </svg>
                            {{ $config['title'] }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">{{ $config['description'] }}</p>
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
                                    @include('admin.settings.partials.field', ['setting' => $setting])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

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

// Settings tab functionality
function showSettingsTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.settings-tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.settings-tab-btn');
    tabButtons.forEach(button => {
        button.classList.remove('active', 'border-[#0073b7]', 'text-[#0073b7]');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    const selectedTab = document.getElementById(`${tabName}-tab`);
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    
    // Add active class to clicked button
    const activeButton = event.target.closest('.settings-tab-btn');
    if (activeButton) {
        activeButton.classList.add('active', 'border-[#0073b7]', 'text-[#0073b7]');
        activeButton.classList.remove('border-transparent', 'text-gray-500');
    }
}

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