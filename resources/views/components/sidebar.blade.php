<aside>
    <!-- Press Releases -->
    <div class="bg-gradient-to-br from-[#0073b7] to-[#004a7f] text-white p-4 mb-6 shadow-lg rounded-lg">
        <div class="flex justify-between items-center border-b border-[#0073b7]/30 pb-2 mb-3">
            <h3 class="text-xl font-bold">| प्रेस विज्ञप्ति</h3>
            <a href="{{ route('press-release') }}" class="text-sm bg-white text-[#004a7f] px-3 py-1 rounded-md hover:bg-white/90 hover:text-[#0073b7] transition-colors shadow-sm">सबै हेर्नुहोस्</a>
        </div>
        <ul>
            @if($pressReleases && $pressReleases->count() > 0)
                @foreach($pressReleases as $release)
                    <li class="border-b border-white/20 last:border-b-0 py-2">
                        <a href="{{ route('press-release.show', $release->slug) }}" class="flex items-start text-white/90 hover:text-white transition-colors">
                            <span class="mr-2 mt-1 text-white/70">&raquo;</span>
                            <span class="flex-1 text-sm">
                                {{ Str::limit($release->title, 60) }}
                                <div class="text-xs text-white/70 mt-1">{{ $release->published_at->format('Y-m-d') }}</div>
                            </span>
                        </a>
                    </li>
                @endforeach
            @else
                @foreach(array_slice(config('site.press_releases', []), 0, 3) as $release)
                    <li class="border-b border-white/20 last:border-b-0 py-2">
                        <a href="{{ route('press-release') }}" class="flex items-start text-white/90 hover:text-white transition-colors">
                            <span class="mr-2 mt-1 text-white/70">&raquo;</span>
                            <span class="flex-1 text-sm">
                                {{ $release['title'] }}
                                <div class="text-xs text-white/70 mt-1">{{ $release['date'] }}</div>
                            </span>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    <!-- Notices -->
    <div class="bg-gradient-to-br from-[#004a7f] to-[#003366] text-white p-4 mb-6 shadow-lg rounded-lg">
        <div class="flex justify-between items-center border-b border-[#004a7f]/30 pb-2 mb-3">
            <h3 class="text-xl font-bold">| सूचना</h3>
            <a href="{{ route('notice') }}" class="text-sm bg-white text-[#004a7f] px-3 py-1 rounded-md hover:bg-white/90 hover:text-[#0073b7] transition-colors shadow-sm">सबै हेर्नुहोस्</a>
        </div>
        <ul>
            @if($notices && $notices->count() > 0)
                @foreach($notices->take(5) as $notice)
                    <li class="border-b border-white/20 last:border-b-0 py-2">
                        <a href="{{ route('notice.show', $notice->slug) }}" class="flex items-start text-white/90 hover:text-white transition-colors">
                            <span class="mr-2 mt-1 text-white/70">&raquo;</span>
                            <span class="flex-1 text-sm">
                                {{ Str::limit($notice->title, 60) }}
                                <div class="text-xs text-white/70 mt-1">{{ $notice->published_at->format('Y-m-d') }}</div>
                            </span>
                        </a>
                    </li>
                @endforeach
            @else
                @foreach(array_slice(config('site.notices_data', []), 0, 5) as $notice)
                    <li class="border-b border-white/20 last:border-b-0 py-2">
                        <a href="{{ route('notice') }}" class="flex items-start text-white/90 hover:text-white transition-colors">
                            <span class="mr-2 mt-1 text-white/70">&raquo;</span>
                            <span class="flex-1 text-sm">
                                {{ $notice['title'] }}
                                <div class="text-xs text-white/70 mt-1">{{ $notice['date'] }}</div>
                            </span>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>


    <!-- Check Membership Button -->
    <button onclick="openMembershipModal()" class="w-full bg-[#0073b7] text-white font-bold py-3 flex items-center justify-center hover:bg-[#004a7f] transition-colors shadow-lg rounded-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        Check your Membership
    </button>
</aside>