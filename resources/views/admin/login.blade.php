@extends('layouts.app')

@section('title', 'Admin Login - नेपाल पत्रकार महासंघ')
@section('breadcrumb', 'Admin Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#0073b7] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#004a7f]">Admin Login</h1>
            <p class="text-gray-600 mt-2">नेपाल पत्रकार महासंघ</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.authenticate') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-[#0073b7] border-gray-300 rounded focus:ring-[#0073b7]">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                
                <a href="#" class="text-sm text-[#0073b7] hover:underline">Forgot password?</a>
            </div>
            
            <button type="submit" 
                    class="w-full bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-2 px-4 rounded-md transition-colors">
                Login
            </button>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Demo Credentials:</h3>
            <div class="text-xs text-gray-600 space-y-1">
                <p><strong>Admin:</strong> admin@fnjnepal.org / admin123</p>
                <p><strong>Editor:</strong> editor@fnjnepal.org / editor123</p>
            </div>
        </div>
        
        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-[#0073b7] transition-colors">
                ← Back to Home
            </a>
        </div>
    </div>
</div>
@endsection