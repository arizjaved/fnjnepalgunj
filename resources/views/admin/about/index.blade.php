@extends('layouts.admin')

@section('title', 'About Page Management - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">About Page Management</h1>
            <p class="text-gray-600">Manage the about page content sections individually</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $aboutPage->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($aboutPage->status) }}
            </span>
        </div>
    </div>

    <!-- Main About Section -->
    <div class="bg-white rounded-lg shadow-md p-6" id="main-section">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                {{ $aboutPage->title }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="editSection('main')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                    Edit
                </button>
            </div>
        </div>
        
        <div class="space-y-4 text-gray-700 leading-relaxed" id="main-content-display">
            @if(is_array($aboutPage->main_content) && count($aboutPage->main_content) > 0)
                @foreach($aboutPage->main_content as $paragraph)
                    <p class="text-justify">{{ $paragraph }}</p>
                @endforeach
            @else
                <p class="text-gray-500 italic">No main content available</p>
            @endif
        </div>
        
        <!-- Edit Form (Hidden by default) -->
        <div id="main-edit-form" class="hidden mt-4">
            <form onsubmit="updateSection(event, 'main')">
                <div id="main-content-inputs">
                    @if(is_array($aboutPage->main_content) && count($aboutPage->main_content) > 0)
                        @foreach($aboutPage->main_content as $index => $paragraph)
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph {{ $index + 1 }}</label>
                                <textarea name="main_content[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required>{{ $paragraph }}</textarea>
                            </div>
                        @endforeach
                    @else
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph 1</label>
                            <textarea name="main_content[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required></textarea>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addMainContentParagraph()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Paragraph</button>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Update
                    </button>
                    <button type="button" onclick="cancelEdit('main')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Vision & Mission Section -->
    <div class="bg-white rounded-lg shadow-md p-6" id="vision-mission-section">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-[#004a7f] rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                दृष्टिकोण र लक्ष्य
            </h2>
            <button onclick="editSection('vision-mission')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                Edit
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="vision-mission-display">
            <div class="bg-gradient-to-br from-[#0073b7] to-[#004a7f] rounded-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4">दृष्टिकोण</h3>
                <p class="leading-relaxed">{{ $aboutPage->vision ?: 'No vision statement available' }}</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">मिशन</h3>
                @if(is_array($aboutPage->mission) && count($aboutPage->mission) > 0)
                    <ul class="space-y-2">
                        @foreach($aboutPage->mission as $mission)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-[#0073b7] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $mission }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic">No mission points available</p>
                @endif
            </div>
        </div>

        <!-- Edit Form (Hidden by default) -->
        <div id="vision-mission-edit-form" class="hidden mt-4">
            <form onsubmit="updateSection(event, 'vision-mission')">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vision Statement</label>
                        <textarea name="vision" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">{{ $aboutPage->vision }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mission Points</label>
                        <div id="mission-inputs">
                            @if(is_array($aboutPage->mission) && count($aboutPage->mission) > 0)
                                @foreach($aboutPage->mission as $mission)
                                    <div class="mb-2">
                                        <input type="text" name="mission[]" value="{{ $mission }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-2">
                                    <input type="text" name="mission[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Mission point 1">
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addMissionPoint()" class="text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Mission Point</button>
                    </div>
                </div>
                <div class="flex space-x-2 mt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Update
                    </button>
                    <button type="button" onclick="cancelEdit('vision-mission')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Objectives Section -->
    <div class="bg-white rounded-lg shadow-md p-6" id="objectives-section">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-[#0073b7] rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                मुख्य उद्देश्यहरू
            </h2>
            <button onclick="editSection('objectives')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg text-sm transition-colors">
                Edit
            </button>
        </div>
        
        <div id="objectives-display">
            @if(is_array($aboutPage->objectives) && count($aboutPage->objectives) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($aboutPage->objectives as $index => $objective)
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-[#0073b7] text-white rounded-full flex items-center justify-center mr-3 flex-shrink-0 text-sm font-bold">
                                {{ $index + 1 }}
                            </div>
                            <span class="text-gray-700">{{ $objective }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No objectives available</p>
            @endif
        </div>

        <!-- Edit Form (Hidden by default) -->
        <div id="objectives-edit-form" class="hidden mt-4">
            <form onsubmit="updateSection(event, 'objectives')">
                <div id="objectives-inputs">
                    @if(is_array($aboutPage->objectives) && count($aboutPage->objectives) > 0)
                        @foreach($aboutPage->objectives as $objective)
                            <div class="mb-2">
                                <input type="text" name="objectives[]" value="{{ $objective }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2">
                            <input type="text" name="objectives[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Objective 1">
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addObjective()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Objective</button>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Update
                    </button>
                    <button type="button" onclick="cancelEdit('objectives')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Content Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Quick Facts -->
        <div class="bg-white rounded-lg shadow-md p-6" id="quick-facts-section">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    तथ्याङ्कहरू
                </h3>
                <button onclick="editSection('quick-facts')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-3 py-1 rounded text-sm transition-colors">
                    Edit
                </button>
            </div>
            
            <div id="quick-facts-display">
                @if(is_array($aboutPage->quick_facts) && count($aboutPage->quick_facts) > 0)
                    <ul class="space-y-3">
                        @foreach($aboutPage->quick_facts as $fact)
                            <li class="flex items-center text-sm text-gray-600 p-2 bg-gray-50 rounded">
                                <svg class="w-4 h-4 mr-2 text-[#0073b7]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $fact }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic">No quick facts available</p>
                @endif
            </div>

            <!-- Edit Form (Hidden by default) -->
            <div id="quick-facts-edit-form" class="hidden mt-4">
                <form onsubmit="updateSection(event, 'quick-facts')">
                    <div id="facts-inputs">
                        @if(is_array($aboutPage->quick_facts) && count($aboutPage->quick_facts) > 0)
                            @foreach($aboutPage->quick_facts as $fact)
                                <div class="mb-2">
                                    <input type="text" name="quick_facts[]" value="{{ $fact }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2">
                                <input type="text" name="quick_facts[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Fact 1">
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addQuickFact()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Fact</button>
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Update
                        </button>
                        <button type="button" onclick="cancelEdit('quick-facts')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leadership -->
        <div class="bg-white rounded-lg shadow-md p-6" id="leadership-section">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 text-[#0073b7] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    नेतृत्व
                </h3>
                <button onclick="editSection('leadership')" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-3 py-1 rounded text-sm transition-colors">
                    Edit
                </button>
            </div>
            
            <div id="leadership-display">
                @if(is_array($aboutPage->leadership_positions) && count($aboutPage->leadership_positions) > 0)
                    <ul class="space-y-2">
                        @foreach($aboutPage->leadership_positions as $position)
                            <li class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-[#004a7f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                {{ $position }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic">No leadership positions available</p>
                @endif
            </div>

            <!-- Edit Form (Hidden by default) -->
            <div id="leadership-edit-form" class="hidden mt-4">
                <form onsubmit="updateSection(event, 'leadership')">
                    <div id="leadership-inputs">
                        @if(is_array($aboutPage->leadership_positions) && count($aboutPage->leadership_positions) > 0)
                            @foreach($aboutPage->leadership_positions as $position)
                                <div class="mb-2">
                                    <input type="text" name="leadership_positions[]" value="{{ $position }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2">
                                <input type="text" name="leadership_positions[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Position 1">
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addLeadershipPosition()" class="mb-3 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Position</button>
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Update
                        </button>
                        <button type="button" onclick="cancelEdit('leadership')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function editSection(section) {
    // Hide display and show edit form
    const displayElement = document.getElementById(section + '-display') || document.getElementById(section + '-content-display');
    const editForm = document.getElementById(section + '-edit-form');
    
    if (displayElement) displayElement.style.display = 'none';
    if (editForm) editForm.classList.remove('hidden');
}

function cancelEdit(section) {
    // Show display and hide edit form
    const displayElement = document.getElementById(section + '-display') || document.getElementById(section + '-content-display');
    const editForm = document.getElementById(section + '-edit-form');
    
    if (displayElement) displayElement.style.display = 'block';
    if (editForm) editForm.classList.add('hidden');
}

function updateSection(event, section) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('section', section);
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    fetch('{{ route("admin.about.update-section") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Section updated successfully!', 'success');
            // Reload to show updated content
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Error updating section: ' + data.message, 'error');
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating section', 'error');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function createMainContentModal() {
    const mainContent = @json($aboutPage->main_content ?? []);
    let contentInputs = '';
    
    mainContent.forEach((paragraph, index) => {
        contentInputs += `
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph ${index + 1}</label>
                <textarea name="main_content[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required>${paragraph}</textarea>
            </div>
        `;
    });
    
    return `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form onsubmit="updateSection(event, 'main')">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Main Content</h3>
                        <div id="main-content-inputs">
                            ${contentInputs}
                        </div>
                        <button type="button" onclick="addMainContentParagraph()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Paragraph</button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#0073b7] text-base font-medium text-white hover:bg-[#004a7f] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function createVisionMissionModal() {
    const vision = @json($aboutPage->vision ?? '');
    const mission = @json($aboutPage->mission ?? []);
    
    let missionInputs = '';
    mission.forEach((item, index) => {
        missionInputs += `
            <div class="mb-2">
                <input type="text" name="mission[]" value="${item}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Mission point ${index + 1}">
            </div>
        `;
    });
    
    return `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form onsubmit="updateSection(event, 'vision-mission')">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Vision & Mission</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Vision Statement</label>
                            <textarea name="vision" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]">${vision}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mission Points</label>
                            <div id="mission-inputs">
                                ${missionInputs}
                            </div>
                            <button type="button" onclick="addMissionPoint()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Mission Point</button>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#0073b7] text-base font-medium text-white hover:bg-[#004a7f] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function createObjectivesModal() {
    const objectives = @json($aboutPage->objectives ?? []);
    
    let objectiveInputs = '';
    objectives.forEach((objective, index) => {
        objectiveInputs += `
            <div class="mb-2">
                <input type="text" name="objectives[]" value="${objective}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Objective ${index + 1}">
            </div>
        `;
    });
    
    return `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form onsubmit="updateSection(event, 'objectives')">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Objectives</h3>
                        <div id="objectives-inputs">
                            ${objectiveInputs}
                        </div>
                        <button type="button" onclick="addObjective()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Objective</button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#0073b7] text-base font-medium text-white hover:bg-[#004a7f] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function createQuickFactsModal() {
    const quickFacts = @json($aboutPage->quick_facts ?? []);
    
    let factInputs = '';
    quickFacts.forEach((fact, index) => {
        factInputs += `
            <div class="mb-2">
                <input type="text" name="quick_facts[]" value="${fact}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Fact ${index + 1}">
            </div>
        `;
    });
    
    return `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form onsubmit="updateSection(event, 'quick-facts')">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Quick Facts</h3>
                        <div id="facts-inputs">
                            ${factInputs}
                        </div>
                        <button type="button" onclick="addQuickFact()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Fact</button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#0073b7] text-base font-medium text-white hover:bg-[#004a7f] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function createLeadershipModal() {
    const leadership = @json($aboutPage->leadership_positions ?? []);
    
    let leadershipInputs = '';
    leadership.forEach((position, index) => {
        leadershipInputs += `
            <div class="mb-2">
                <input type="text" name="leadership_positions[]" value="${position}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Position ${index + 1}">
            </div>
        `;
    });
    
    return `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form onsubmit="updateSection(event, 'leadership')">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Leadership Positions</h3>
                        <div id="leadership-inputs">
                            ${leadershipInputs}
                        </div>
                        <button type="button" onclick="addLeadershipPosition()" class="mt-2 text-sm text-[#0073b7] hover:text-[#004a7f]">+ Add Position</button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#0073b7] text-base font-medium text-white hover:bg-[#004a7f] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function closeModal() {
    const modal = document.getElementById('edit-modal');
    if (modal) {
        modal.remove();
    }
}

function updateSection(event, section) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('section', section);
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    fetch('{{ route("admin.about.update-section") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Section updated successfully!', 'success');
            // Reload to show updated content
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Error updating section: ' + data.message, 'error');
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating section', 'error');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Helper functions for adding dynamic inputs
function addMainContentParagraph() {
    const container = document.getElementById('main-content-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-3';
    div.innerHTML = `
        <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph ${count}</label>
        <textarea name="main_content[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required></textarea>
    `;
    container.appendChild(div);
}

function addMissionPoint() {
    const container = document.getElementById('mission-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="mission[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Mission point ${count}">`;
    container.appendChild(div);
}

function addObjective() {
    const container = document.getElementById('objectives-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="objectives[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Objective ${count}">`;
    container.appendChild(div);
}

function addQuickFact() {
    const container = document.getElementById('facts-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="quick_facts[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Fact ${count}">`;
    container.appendChild(div);
}

function addLeadershipPosition() {
    const container = document.getElementById('leadership-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="leadership_positions[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Position ${count}">`;
    container.appendChild(div);
}


// Helper functions for adding dynamic inputs
function addMainContentParagraph() {
    const container = document.getElementById('main-content-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-3';
    div.innerHTML = `
        <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph ${count}</label>
        <textarea name="main_content[]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" required></textarea>
    `;
    container.appendChild(div);
}

function addMissionPoint() {
    const container = document.getElementById('mission-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="mission[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Mission point ${count}">`;
    container.appendChild(div);
}

function addObjective() {
    const container = document.getElementById('objectives-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="objectives[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Objective ${count}">`;
    container.appendChild(div);
}

function addQuickFact() {
    const container = document.getElementById('facts-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="quick_facts[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Fact ${count}">`;
    container.appendChild(div);
}

function addLeadershipPosition() {
    const container = document.getElementById('leadership-inputs');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<input type="text" name="leadership_positions[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7]" placeholder="Position ${count}">`;
    container.appendChild(div);
}
</script>