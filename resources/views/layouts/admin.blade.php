<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - नेपाल पत्रकार महासंघ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg flex flex-col flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center">
                    <img src="https://placehold.co/40x40/0073b7/ffffff/png?text=FNJ" alt="FNJ Logo" class="w-10 h-10 rounded-lg mr-3">
                    <div>
                        <h2 class="text-lg font-bold text-[#004a7f]">FNJ Admin</h2>
                        <p class="text-xs text-gray-500">Management Panel</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <div class="px-6 py-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dashboard</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Dashboard
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Content Management</p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.news.*') && !request()->routeIs('admin.news-categories.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    News Articles
                </a>
                <a href="{{ route('admin.news-categories.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.news-categories.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    News Categories
                </a>
                <a href="{{ route('admin.press-releases.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.press-releases.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                    </svg>
                    Press Releases
                </a>
                <a href="{{ route('admin.notices.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.notices.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Notices
                </a>
                <a href="{{ route('admin.publications.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.publications.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Publications
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Media Gallery</p>
                </div>
                <a href="{{ route('admin.photo-gallery.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.photo-gallery.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Photo Gallery
                </a>
                <a href="{{ route('admin.video-gallery.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.video-gallery.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Video Gallery
                </a>
                <a href="{{ route('admin.media-categories.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.media-categories.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Media Categories
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">User Management</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    All Users
                </a>
                <a href="{{ route('admin.users.create') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.users.create') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Add User
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Membership</p>
                </div>
                <a href="{{ route('admin.memberships.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.memberships.index') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Members List
                </a>
                <a href="{{ route('admin.memberships.create') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.memberships.create') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Add New Member
                </a>
                <a href="{{ route('admin.membership-categories.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.membership-categories.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Membership Categories
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Communications</p>
                </div>
                <a href="{{ route('admin.complaints.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.complaints.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Complaints
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Messages
                </a>

                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Website Pages</p>
                </div>
                @if(Route::has('admin.page-titles.index'))
                    <a href="{{ route('admin.page-titles.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.page-titles.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Page Titles
                    </a>
                @else
                    <span class="flex items-center px-6 py-3 text-gray-400 cursor-not-allowed">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Page Titles (Coming Soon)
                    </span>
                @endif
                <a href="{{ route('admin.about.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.about.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    About Page
                </a>
                <a href="{{ route('admin.committee.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.committee.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Committee Page
                </a>
                <a href="{{ route('admin.contact-page.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.contact-page.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Contact Page
                </a>
                
                <div class="px-6 py-2 mt-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-[#0073b7]/10 text-[#0073b7] border-r-2 border-[#0073b7]' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Site Settings
                </a>
                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#0073b7]/10 hover:text-[#0073b7] transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Website
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-auto overflow-y-auto bg-gray-100 p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-yellow-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-sm text-gray-600">
                        <p>Designed and developed by <span class="font-semibold text-[#0073b7]">Dotworks</span></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <style>
        /* Custom scrollbar styles */
        .scrollbar-thin {
            scrollbar-width: thin;
        }
        
        .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 0.375rem;
        }
        
        .scrollbar-track-gray-100::-webkit-scrollbar-track {
            background-color: #f3f4f6;
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 0.375rem;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: #9ca3af;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background-color: #f3f4f6;
        }
    </style>
</body>
</html>
