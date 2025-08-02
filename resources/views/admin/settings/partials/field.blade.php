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