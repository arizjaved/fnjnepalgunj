@extends('layouts.admin')

@section('title', 'Complaints Management - Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Complaints Management</h1>
            <p class="text-gray-600">Manage and respond to user complaints</p>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <a href="{{ route('admin.complaints.index') }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ !request('status') ? 'border-[#0073b7] text-[#0073b7]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    All Complaints
                    <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['all'] }}</span>
                </a>
                <a href="{{ route('admin.complaints.index', ['status' => 'pending']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pending
                    <span class="ml-2 bg-yellow-100 text-yellow-800 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['pending'] }}</span>
                </a>
                <a href="{{ route('admin.complaints.index', ['status' => 'in_process']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'in_process' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    In Process
                    <span class="ml-2 bg-blue-100 text-blue-800 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['in_process'] }}</span>
                </a>
                <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'resolved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Resolved
                    <span class="ml-2 bg-green-100 text-green-800 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['resolved'] }}</span>
                </a>
                <a href="{{ route('admin.complaints.index', ['status' => 'rejected']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rejected
                    <span class="ml-2 bg-red-100 text-red-800 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['rejected'] }}</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search complaints by name, email, subject, or message..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            </div>
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-6 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.complaints.index', request()->only('status')) }}" 
                       class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6" id="bulk-actions" style="display: none;">
        <div class="p-4 border-b border-gray-200">
            <form method="POST" action="{{ route('admin.complaints.bulk-update') }}" id="bulk-form">
                @csrf
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        <span id="selected-count">0</span> complaints selected
                    </span>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <option value="">Select Action</option>
                        <option value="pending">Mark as Pending</option>
                        <option value="in_process">Mark as In Process</option>
                        <option value="resolved">Mark as Resolved</option>
                        <option value="rejected">Mark as Rejected</option>
                    </select>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                        Apply
                    </button>
                    <button type="button" 
                            onclick="clearSelection()"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        Clear Selection
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Complainant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
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
                        @foreach($complaints as $complaint)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" 
                                           name="complaint_ids[]" 
                                           value="{{ $complaint->id }}" 
                                           class="complaint-checkbox rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="text-sm font-medium text-gray-900">{{ $complaint->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $complaint->email }}</div>
                                        @if($complaint->phone)
                                            <div class="text-sm text-gray-500">{{ $complaint->phone }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($complaint->subject, 50) }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($complaint->message, 100) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $complaint->status_badge }}">
                                        {{ $complaint->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div>{{ $complaint->created_at->format('M d, Y') }}</div>
                                    <div>{{ $complaint->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                           class="text-[#0073b7] hover:text-[#004a7f] transition-colors duration-200">
                                            View
                                        </a>
                                        <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this complaint?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $complaints->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No complaints found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                        No complaints match your search criteria.
                    @else
                        No complaints have been submitted yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const complaintCheckboxes = document.querySelectorAll('.complaint-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const bulkForm = document.getElementById('bulk-form');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        complaintCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    complaintCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });

    function updateSelectAll() {
        const checkedBoxes = document.querySelectorAll('.complaint-checkbox:checked');
        selectAllCheckbox.checked = checkedBoxes.length === complaintCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < complaintCheckboxes.length;
    }

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.complaint-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    // Add selected IDs to bulk form
    bulkForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.complaint-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one complaint.');
            return;
        }

        // Remove existing hidden inputs
        const existingInputs = bulkForm.querySelectorAll('input[name="complaint_ids[]"]');
        existingInputs.forEach(input => input.remove());

        // Add selected IDs
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'complaint_ids[]';
            input.value = checkbox.value;
            bulkForm.appendChild(input);
        });
    });

    window.clearSelection = function() {
        complaintCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
        bulkActions.style.display = 'none';
    };
});
</script>
@endsection