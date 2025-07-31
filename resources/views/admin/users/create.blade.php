@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create User</h1>
            <p class="text-gray-600">Add a new user to the system</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">User Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('name') border-red-500 @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Enter full name...">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('email') border-red-500 @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="Enter email address...">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('password') border-red-500 @enderror" 
                                   id="password" name="password" required
                                   placeholder="Enter password...">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Minimum 8 characters required</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent" 
                                   id="password_confirmation" name="password_confirmation" required
                                   placeholder="Confirm password...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3 width) -->
            <div class="space-y-6">
                <!-- User Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">User Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('role') border-red-500 @enderror" 
                                    id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="editor" {{ old('role', 'editor') === 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                <span class="ml-2 text-sm text-gray-700">Active User</span>
                            </label>
                            <p class="text-gray-500 text-sm mt-1">Inactive users cannot log in</p>
                        </div>
                    </div>
                </div>

                <!-- Role Information -->
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Role Permissions</h3>
                    <div class="space-y-3 text-sm text-blue-800">
                        <div>
                            <h4 class="font-medium">Admin</h4>
                            <ul class="list-disc list-inside text-xs space-y-1 mt-1">
                                <li>Full system access</li>
                                <li>User management</li>
                                <li>Content management</li>
                                <li>System settings</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium">Editor</h4>
                            <ul class="list-disc list-inside text-xs space-y-1 mt-1">
                                <li>Content creation and editing</li>
                                <li>Publish articles</li>
                                <li>Manage own content</li>
                                <li>Limited system access</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span>Create User</span>
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection