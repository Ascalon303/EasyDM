<header class="sticky top-0 z-30 bg-stone-900/95 backdrop-blur border-b border-stone-800 px-6 py-3 flex items-center justify-between">

    {{-- Page title --}}
    <div>
        <h1 class="font-cinzel text-gold-400 font-semibold text-lg tracking-wider">@yield('page-title', 'Dashboard')</h1>
        @hasSection('breadcrumb')
            <div class="text-stone-500 text-xs mt-0.5">@yield('breadcrumb')</div>
        @endif
    </div>

    {{-- Right side --}}
    <div class="flex items-center gap-4">

        @auth
            {{-- Profile link --}}
            <a href="{{ route('profile.show') }}" class="flex items-center gap-2 text-stone-400 hover:text-gold-400 transition-colors text-sm">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-bold text-stone-900 text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="hidden md:block">{{ auth()->user()->name }}</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-stone-400 hover:text-gold-400 text-sm transition-colors font-cinzel">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-1.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-semibold text-sm rounded transition-colors">Join</a>
        @endauth

    </div>
</header>
