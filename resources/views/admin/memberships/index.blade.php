@extends('layouts.admin')

@section('title', 'Memberships - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Memberships</h1>
            <p class="text-gray-600">Manage member applications and records</p>
        </div>
        <a href="{{ route('admin.memberships.create') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Member
        </a>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.memberships.index') }}" class="px-4 py-2 {{ !request('status') ? 'bg-[#0073b7] text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-[#004a7f] hover:text-white transition-colors text-sm">
                All ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.memberships.index', ['status' => 'pending']) }}" class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-yellow-600 hover:text-white transition-colors text-sm">
                Pending ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.memberships.index', ['status' => 'approved']) }}" class="px-4 py-2 {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-green-600 hover:text-white transition-colors text-sm">
                Approved ({{ $statusCounts['approved'] }})
            </a>
            <a href="{{ route('admin.memberships.index', ['status' => 'rejected']) }}" class="px-4 py-2 {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-red-600 hover:text-white transition-colors text-sm">
                Rejected ({{ $statusCounts['rejected'] }})
            </a>
            <a href="{{ route('admin.memberships.index', ['status' => 'expired']) }}" class="px-4 py-2 {{ request('status') == 'expired' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-lg hover:bg-gray-600 hover:text-white transition-colors text-sm">
                Expired ({{ $statusCounts['expired'] }})
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <form method="GET" class="flex gap-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, member ID, or phone..." 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg transition-colors">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.memberships.index', ['status' => request('status')]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Memberships Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">S.N.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($memberships as $index => $membership)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ($memberships->currentPage() - 1) * $memberships->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $membership->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $membership->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $membership->phone }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $membership->member_id ?: 'Not assigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $membership->membership_type_display }}
                                    </span>
                                    @if($membership->is_executive_committee)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            कार्यकारी समिति
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $membership->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($membership->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($membership->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($membership->status) }}
                                </span>
                                @if($membership->expires_at)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Expires: {{ $membership->expires_at->format('Y-m-d') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $membership->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.memberships.show', $membership) }}" class="text-[#0073b7] hover:text-[#004a7f]" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.memberships.edit', $membership) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @if($membership->status === 'pending')
                                        <form action="{{ route('admin.memberships.approve', $membership) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800" title="Approve" onclick="return confirm('Are you sure you want to approve this membership?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.memberships.destroy', $membership) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this membership? This action cannot be undone.')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">No memberships found</p>
                                <p class="text-sm">No membership applications match your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($memberships->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                {{ $memberships->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection