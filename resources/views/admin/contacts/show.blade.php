@extends('layouts.admin')

@section('title', 'View Contact - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Contact Details</h1>
            <p class="text-gray-600">Review and manage contact message</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Contacts
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Contact Information</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $contact->status_badge }}">
                        {{ $contact->status_label }}
                    </span>
                </div>

                <div class="space-y-6">
                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Contact Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <p class="text-sm text-gray-900">{{ $contact->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-sm text-gray-900">
                                    <a href="mailto:{{ $contact->email }}" class="text-[#0073b7] hover:text-[#004a7f]">
                                        {{ $contact->email }}
                                    </a>
                                </p>
                            </div>
                            @if($contact->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <p class="text-sm text-gray-900">
                                        <a href="tel:{{ $contact->phone }}" class="text-[#0073b7] hover:text-[#004a7f]">
                                            {{ $contact->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Submitted</label>
                                <p class="text-sm text-gray-900">{{ $contact->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Message Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $contact->subject }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg whitespace-pre-wrap">{{ $contact->message }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Received Info -->
                    @if($contact->received_at)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Processing Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Received By</label>
                                    <p class="text-sm text-gray-900">{{ $contact->receiver->name ?? 'Unknown' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Received At</label>
                                    <p class="text-sm text-gray-900">{{ $contact->received_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Admin Notes -->
                    @if($contact->admin_notes)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Admin Notes</h3>
                            <div class="text-sm text-gray-900 bg-blue-50 p-3 rounded-lg whitespace-pre-wrap">{{ $contact->admin_notes }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Manage Status</h2>

                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('status') border-red-500 @enderror"
                                required>
                            <option value="pending" {{ $contact->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="received" {{ $contact->status === 'received' ? 'selected' : '' }}>Received</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Notes
                        </label>
                        <textarea id="admin_notes" 
                                  name="admin_notes" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('admin_notes') border-red-500 @enderror"
                                  placeholder="Add internal notes about this contact...">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">These notes are for internal use only and will not be visible to the contact.</p>
                    </div>

                    <button type="submit" 
                            class="w-full px-4 py-2 bg-[#0073b7] hover:bg-[#004a7f] text-white font-medium rounded-lg transition-colors duration-200">
                        Update Status
                    </button>
                </form>

                <!-- Quick Actions -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Reply via Email
                        </a>
                        @if($contact->phone)
                            <a href="tel:{{ $contact->phone }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Delete Action -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this contact? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Delete Contact
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection