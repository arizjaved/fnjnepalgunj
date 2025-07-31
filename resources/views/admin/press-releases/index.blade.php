@extends('layouts.admin')

@section('title', 'Press Releases')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Press Releases</h1>
            <p class="text-gray-600">Manage your press releases and announcements</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.press-releases.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Press Release
            </a>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.press-releases.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search press releases..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            </div>
            <div class="sm:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    Search
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.press-releases.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <form id="bulk-action-form" method="POST" action="{{ route('admin.press-releases.bulk-action') }}">
        @csrf
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <!-- Bulk Actions Bar -->
            <div class="p-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                            <span class="ml-2 text-sm text-gray-600">Select All</span>
                        </label>
                        <span id="selected-count" class="text-sm text-gray-500">0 selected</span>
                    </div>
                    <div class="flex gap-2">
                        <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                            <option value="">Bulk Actions</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Move to Draft</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" 
                                class="px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white text-sm rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Press Releases Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="sr-only">Select</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Author
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pressReleases as $pressRelease)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           name="selected_items[]" 
                                           value="{{ $pressRelease->id }}" 
                                           class="item-checkbox rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($pressRelease->featured_image)
                                            <img src="{{ $pressRelease->featured_image_url }}" 
                                                 alt="{{ $pressRelease->title }}" 
                                                 class="w-12 h-12 object-cover rounded-lg mr-4">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('admin.press-releases.show', $pressRelease) }}" 
                                                   class="hover:text-[#0073b7] transition-colors">
                                                    {{ Str::limit($pressRelease->title, 50) }}
                                                </a>
                                            </div>
                                            @if($pressRelease->excerpt)
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($pressRelease->excerpt, 80) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pressRelease->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pressRelease->creator->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $pressRelease->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $pressRelease->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.press-releases.show', $pressRelease) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('admin.press-releases.edit', $pressRelease) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.press-releases.destroy', $pressRelease) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this press release?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No press releases found</h3>
                                        <p class="text-gray-500 mb-4">Get started by creating your first press release.</p>
                                        <a href="{{ route('admin.press-releases.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Create Press Release
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Pagination -->
    @if($pressReleases->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            {{ $pressReleases->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const applyButton = bulkActionForm.querySelector('button[type="submit"]');
    
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCountSpan.textContent = `${count} selected`;
        applyButton.disabled = count === 0;
        
        selectAllCheckbox.checked = count === itemCheckboxes.length;
        selectAllCheckbox.indeterminate = count > 0 && count < itemCheckboxes.length;
    }
    
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });
    
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    bulkActionForm.addEventListener('submit', function(e) {
        const action = this.querySelector('select[name="action"]').value;
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        
        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one press release.');
            return;
        }
        
        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} press release(s)? This action cannot be undone.`)) {
                e.preventDefault();
                return;
            }
        }
    });
    
    updateSelectedCount();
});
</script>
@endsection