<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'नेपाल पत्रकार महासंघ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-lg">
        <!-- Header -->
        <header class="relative">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-slate-50 to-blue-50 border-b border-slate-200 text-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-2">
                    <div class="flex space-x-6">
                        <a href="{{ route('membership.index') }}" class="flex items-center text-slate-600 hover:text-[#0073b7] transition-colors duration-200 font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Membership / Renewal Form
                        </a>

                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-3 bg-white rounded-full px-3 py-1 shadow-sm border border-slate-200">
                            <span id="english-label" class="text-slate-600 text-xs font-medium">English</span>
                            <button id="language-toggle" class="relative inline-flex flex-shrink-0 h-5 w-9 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none bg-[#0073b7] hover:bg-[#004a7f]">
                                <span id="toggle-switch" class="inline-block h-4 w-4 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-4"></span>
                            </button>
                            <span id="nepali-label" class="text-slate-700 font-semibold text-xs">नेपाली</span>
                        </div>
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="tel:+97715914785" class="flex items-center text-slate-600 hover:text-[#0073b7] transition-colors duration-200">
                                <div class="bg-[#0073b7]/10 p-1.5 rounded-full mr-2">
                                    <svg class="w-3 h-3 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium">+९७७-१-५९१४७८५</span>
                            </a>
                            <a href="mailto:fnjnepalcentral@gmail.com" class="flex items-center text-slate-600 hover:text-[#0073b7] transition-colors duration-200">
                                <div class="bg-[#004a7f]/10 p-1.5 rounded-full mr-2">
                                    <svg class="w-3 h-3 text-[#004a7f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium">fnjnepalcentral@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="relative bg-gradient-to-br from-[#0073b7] via-[#004a7f] to-[#003366] text-white overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
                
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('home') }}" class="flex items-center group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-white rounded-xl blur-sm opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                <img src="https://placehold.co/80x80/ffffff/0073b7/png?text=FNJ" alt="FNJ Logo" class="relative h-20 w-20 mr-6 rounded-xl shadow-2xl border-2 border-white/20 group-hover:scale-105 transition-transform duration-300"/>
                            </div>
                            <div class="space-y-1">
                                <h1 class="text-4xl lg:text-5xl font-bold text-white drop-shadow-lg tracking-tight">
                                    नेपाल पत्रकार महासंघ
                                </h1>
                                <p class="text-lg text-white/80 font-medium tracking-wide">
                                    Federation of Nepali Journalists
                                </p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <div class="flex items-center text-white/70 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        काठमाडौं, नेपाल
                                    </div>
                                    <div class="flex items-center text-white/70 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        स्थापना: २०४६ साल
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Search Box -->
                        <div class="hidden lg:block">
                            <div class="relative">
                                <input type="text" placeholder="खोज्नुहोस्..." class="w-80 pl-10 pr-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/20 transition-all duration-200">
                                <svg class="w-5 h-5 absolute left-3 top-3.5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-white/10 to-transparent rounded-full -translate-y-32 translate-x-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-500/20 to-transparent rounded-full translate-y-24 -translate-x-24"></div>
            </div>

            <!-- Navigation -->
            <nav class="bg-white shadow-lg border-t border-gray-200 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Desktop Navigation -->
                        <div class="flex items-center flex-1">
                            <div class="hidden md:block">
                                <div class="ml-0 flex items-baseline space-x-1">
                                    @foreach(config('site.nav_links') as $link)
                                        @if($link['dropdown'] && isset($link['submenu']))
                                            <!-- Dropdown Menu -->
                                            <div class="relative group">
                                                <button class="relative flex items-center px-4 py-4 text-base font-medium transition-all duration-200 text-slate-700 hover:text-[#0073b7] hover:bg-[#0073b7]/5">
                                                    {{ $link['name'] }}
                                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                                <!-- Dropdown Content -->
                                                <div class="absolute left-0 mt-0 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                                    <div class="py-1">
                                                        @foreach($link['submenu'] as $sublink)
                                                            <a href="{{ $sublink['path'] }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#0073b7]/5 hover:text-[#0073b7] transition-colors">
                                                                {{ $sublink['name'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Regular Menu Item -->
                                            <a href="{{ $link['path'] }}" class="relative flex items-center px-4 py-4 text-base font-medium transition-all duration-200 group {{ request()->is(ltrim($link['path'], '/')) || (request()->is('/') && $link['path'] === '/') ? 'text-[#0073b7] border-b-2 border-[#0073b7]' : 'text-slate-700 hover:text-[#0073b7] hover:bg-[#0073b7]/5' }}">
                                                {{ $link['name'] }}
                                                <!-- Hover underline effect -->
                                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#0073b7] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200 {{ request()->is(ltrim($link['path'], '/')) || (request()->is('/') && $link['path'] === '/') ? 'scale-x-100' : '' }}"></span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Desktop Right Side Actions -->
                        <div class="hidden md:flex items-center space-x-3">
                            <button class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0073b7] transition-colors">
                                <svg class="h-5 w-5 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                            <a href="{{ route('grievance.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-[#0073b7] hover:bg-[#004a7f] rounded-lg transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                उजुरी
                            </a>
                        </div>

                        <!-- Mobile Layout: Menu Button (Left) and Search Button (Right) -->
                        <div class="md:hidden flex items-center justify-between w-full">
                            <button id="mobile-menu-button" class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0073b7] transition-colors">
                                <svg class="h-6 w-6 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <button class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0073b7] transition-colors">
                                <svg class="h-5 w-5 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Menu -->
                <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 pt-2 pb-3 space-y-1">
                        @foreach(config('site.nav_links') as $link)
                            @if($link['dropdown'] && isset($link['submenu']))
                                <!-- Mobile Dropdown -->
                                <div class="mobile-dropdown">
                                    <button class="mobile-dropdown-button w-full flex items-center justify-between px-3 py-2 text-base font-medium text-gray-700 hover:text-[#0073b7] hover:bg-gray-50 rounded-md transition-colors">
                                        {{ $link['name'] }}
                                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="mobile-dropdown-content hidden pl-4 space-y-1">
                                        @foreach($link['submenu'] as $sublink)
                                            <a href="{{ $sublink['path'] }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-[#0073b7] hover:bg-gray-50 rounded-md transition-colors">
                                                {{ $sublink['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Regular Mobile Menu Item -->
                                <a href="{{ $link['path'] }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-[#0073b7] hover:bg-gray-50 rounded-md transition-colors {{ request()->is(ltrim($link['path'], '/')) || (request()->is('/') && $link['path'] === '/') ? 'text-[#0073b7] bg-[#0073b7]/5' : '' }}">
                                    {{ $link['name'] }}
                                </a>
                            @endif
                        @endforeach
                        
                        <!-- Mobile उजुरी Button -->
                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('grievance.index') }}" class="flex items-center justify-center px-4 py-3 text-base font-medium text-white bg-[#0073b7] hover:bg-[#004a7f] rounded-lg transition-colors shadow-sm">
                                <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                उजुरी दर्ता गर्नुहोस्
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto p-4 lg:p-6">
            @if(!request()->is('/'))
                <!-- Breadcrumb for non-home pages -->
                <nav class="mb-4">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-[#0073b7]">गृहपृष्ठ</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-800">@yield('breadcrumb', 'Page')</li>
                    </ol>
                </nav>
            @endif
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-[#004a7f] via-[#0073b7] to-[#004a7f] text-gray-200">
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    
                    <!-- Quick Links -->
                    <div class="md:col-span-1">
                        <h3 class="text-white text-lg font-bold mb-4 border-b border-[#0073b7] pb-2">छिटो लिङ्कहरू</h3>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            @foreach(config('site.footer_links') as $link)
                                <li>
                                    <a href="{{ $link['path'] }}" class="hover:text-white flex items-center">
                                        <span class="mr-2">&raquo;</span>
                                        {{ $link['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Members Of & Social -->
                    <div class="md:col-span-2">
                        <h3 class="text-white text-lg font-bold mb-4 border-b border-[#0073b7] pb-2">MEMBERS OF</h3>
                        <div class="flex items-center space-x-4">
                            <img src="https://placehold.co/100x50/ffffff/0073b7/png?text=IFJ" alt="IFJ Logo" class="h-12"/>
                            <img src="https://placehold.co/100x50/ffffff/0073b7/png?text=IFEX" alt="IFEX Logo" class="h-12"/>
                        </div>
                        <h3 class="text-white text-lg font-bold mt-6 mb-4 border-b border-[#0073b7] pb-2">FOLLOW US ON</h3>
                        <div class="flex space-x-3">
                            <a href="#" class="bg-white/10 hover:bg-white/20 text-white rounded-full p-3 w-12 h-12 flex items-center justify-center transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 text-white rounded-full p-3 w-12 h-12 flex items-center justify-center transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 text-white rounded-full p-3 w-12 h-12 flex items-center justify-center transition-all duration-200 hover:scale-110">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0C.89 3.434-.16 4.45 0 5.166 0 6.818.01 12 0 12s-.01 5.182 0 6.834c.16 1.138.89 1.732 4.385 1.982 3.6.246 11.626.246 15.23 0 3.495-.25 4.225-1.104 4.385-1.982 0-1.652.01-6.834.01-6.834s-.01-5.182 0-6.834C23.84 4.45 23.11 3.434 19.615 3.184zM9 16V8l7 4-7 4z"></path></svg>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 text-white rounded-full p-3 w-12 h-12 flex items-center justify-center transition-all duration-200 hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.221.083.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.747 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="md:col-span-1">
                        <h3 class="text-white text-lg font-bold mb-4 border-b border-[#0073b7] pb-2">सम्पर्क जानकारी</h3>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>मिडिया भिलेज, तिलगंगा काठमाडौं</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>+९७७-१-५९१४७८५, ५९१४७२३</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>fnjnepalcentral@gmail.com</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                <span>+९७७-१-५९१४७८५</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- Newsletter Section -->
                <div class="border-t border-[#0073b7]/30 pt-8 mt-8">
                    <div class="text-center mb-6">
                        <h3 class="text-white text-lg font-bold mb-2">समाचार सदस्यता</h3>
                        <p class="text-gray-300 text-sm">नवीनतम समाचार र अपडेटहरू प्राप्त गर्न सदस्यता लिनुहोस्</p>
                    </div>
                    <form class="max-w-md mx-auto flex gap-2">
                        <input type="email" placeholder="तपाईंको इमेल ठेगाना" class="flex-1 px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                        <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg transition-colors font-medium">
                            सदस्यता
                        </button>
                    </form>
                </div>
            </div>
            <div class="bg-[#004a7f] text-gray-400 text-sm border-t border-slate-700">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center text-center space-y-2 md:space-y-0">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-[#0073b7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            प्रतिलिपी अधिकार © {{ date('Y') }} नेपाल पत्रकार महासंघ। सबै अधिकार सुरक्षित।
                        </p>
                        <div class="flex items-center space-x-4">
                            <a href="#" class="hover:text-[#0073b7] transition-colors">गोपनीयता नीति</a>
                            <span>|</span>
                            <a href="#" class="hover:text-[#0073b7] transition-colors">सेवाका सर्तहरू</a>
                            <span>|</span>
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0073b7] transition-colors flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('admin.login') }}" class="hover:text-[#0073b7] transition-colors flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Admin Login
                                </a>
                            @endauth
                            <span>|</span>
                            <p>Designed and developed by <a href="#" class="text-[#0073b7] hover:text-white hover:underline transition-colors">Dotworks</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Simple carousel functionality
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('[data-carousel]');
            if (carousel) {
                const slides = carousel.querySelectorAll('[data-slide]');
                const dots = carousel.querySelectorAll('[data-dot]');
                let currentSlide = 0;

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.toggle('opacity-100', i === index);
                        slide.classList.toggle('opacity-0', i !== index);
                    });
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('bg-white', i === index);
                        dot.classList.toggle('bg-white/50', i !== index);
                    });
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }

                function prevSlide() {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(currentSlide);
                }

                // Auto-play
                setInterval(nextSlide, 5000);

                // Navigation buttons
                carousel.querySelector('[data-prev]')?.addEventListener('click', prevSlide);
                carousel.querySelector('[data-next]')?.addEventListener('click', nextSlide);

                // Dot navigation
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        currentSlide = index;
                        showSlide(currentSlide);
                    });
                });
            }

            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Mobile dropdown functionality
            const mobileDropdownButtons = document.querySelectorAll('.mobile-dropdown-button');
            mobileDropdownButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');
                    
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Language toggle functionality
            const languageToggle = document.getElementById('language-toggle');
            const toggleSwitch = document.getElementById('toggle-switch');
            const englishLabel = document.getElementById('english-label');
            const nepaliLabel = document.getElementById('nepali-label');
            
            if (languageToggle) {
                languageToggle.addEventListener('click', function() {
                    const isNepali = toggleSwitch.classList.contains('translate-x-4');
                    
                    if (isNepali) {
                        // Switch to English
                        toggleSwitch.classList.remove('translate-x-4');
                        toggleSwitch.classList.add('translate-x-0');
                        englishLabel.classList.remove('text-slate-600');
                        englishLabel.classList.add('text-slate-700', 'font-semibold');
                        nepaliLabel.classList.remove('text-slate-700', 'font-semibold');
                        nepaliLabel.classList.add('text-slate-600');
                        
                        // Here you can add logic to change the language
                        console.log('Switched to English');
                    } else {
                        // Switch to Nepali
                        toggleSwitch.classList.remove('translate-x-0');
                        toggleSwitch.classList.add('translate-x-4');
                        nepaliLabel.classList.remove('text-slate-600');
                        nepaliLabel.classList.add('text-slate-700', 'font-semibold');
                        englishLabel.classList.remove('text-slate-700', 'font-semibold');
                        englishLabel.classList.add('text-slate-600');
                        
                        // Here you can add logic to change the language
                        console.log('Switched to Nepali');
                    }
                });
            }
        });
    </script>
</body>
</html>