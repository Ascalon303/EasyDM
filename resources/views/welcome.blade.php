<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyDM – Forge Your Legend</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: {
                fontFamily: { cinzel: ['Cinzel','serif'], crimson: ['Crimson Text','serif'] },
                colors: {
                    stone: { 950:'#0c0a09', 900:'#1c1917', 800:'#292524', 700:'#44403c' },
                    gold:  { 300:'#fcd34d', 400:'#fbbf24', 500:'#f59e0b' },
                    crimson: { 400:'#f87171', 500:'#ef4444', 600:'#dc2626' },
                    arcane: { 400:'#c084fc', 500:'#a855f7' },
                }
            }}
        }
    </script>
    <style>
        body { background:#0c0a09; color:#e7e5e4; font-family:'Inter',sans-serif; }
        .hero-bg {
            background: radial-gradient(ellipse at 50% 0%, rgba(251,191,36,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 50%, rgba(168,85,247,0.06) 0%, transparent 50%),
                        #0c0a09;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        .float { animation: float 5s ease-in-out infinite; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp 0.8s ease forwards; }
        .fade-up-2 { animation: fadeUp 0.8s ease 0.2s forwards; opacity:0; }
        .fade-up-3 { animation: fadeUp 0.8s ease 0.4s forwards; opacity:0; }
        .fade-up-4 { animation: fadeUp 0.8s ease 0.6s forwards; opacity:0; }
        .card-glow { border:1px solid rgba(251,191,36,0.15); transition:all 0.3s; }
        .card-glow:hover { border-color:rgba(251,191,36,0.4); box-shadow:0 0 30px rgba(251,191,36,0.1); }
        .text-gradient { background: linear-gradient(135deg, #fbbf24, #f87171); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="flex items-center justify-between px-8 py-5 border-b border-stone-800/50">
        <div class="font-cinzel font-black text-2xl tracking-widest">
            <span class="text-gold-400">EASY</span><span class="text-crimson-400">DM</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="text-stone-400 hover:text-gold-400 transition-colors font-cinzel text-sm tracking-wider">LOGIN</a>
            <a href="{{ route('register') }}" class="px-5 py-2 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-wider rounded transition-all hover:shadow-lg hover:shadow-gold-500/20">
                START FREE
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-4 relative overflow-hidden">

        {{-- Decorative elements --}}
        <div class="absolute top-20 left-10 w-64 h-64 rounded-full bg-gold-500/5 blur-3xl float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 rounded-full bg-arcane-500/5 blur-3xl" style="animation:float 7s ease-in-out infinite;"></div>

        <div class="max-w-4xl mx-auto relative z-10">

            <div class="fade-up text-gold-400 font-cinzel text-sm tracking-[0.4rem] mb-6 flex items-center justify-center gap-3">
                <span class="text-stone-600">✦ ✦ ✦</span>
                <span>THE ULTIMATE DM PLATFORM</span>
                <span class="text-stone-600">✦ ✦ ✦</span>
            </div>

            <h1 class="fade-up-2 font-cinzel font-black text-6xl md:text-8xl leading-none mb-6">
                <span class="text-gradient">FORGE</span><br>
                <span class="text-stone-100">YOUR LEGEND</span>
            </h1>

            <p class="fade-up-3 text-stone-400 text-xl md:text-2xl font-crimson italic max-w-2xl mx-auto mb-10 leading-relaxed">
                AI-powered encounter balancing, D&D 5e compendium, campaign management,
                and a creator marketplace — all in one platform.
            </p>

            <div class="fade-up-4 flex items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-base tracking-widest rounded transition-all hover:shadow-xl hover:shadow-gold-500/30 hover:-translate-y-0.5">
                    BEGIN YOUR QUEST
                </a>
                <a href="{{ route('login') }}"
                   class="px-8 py-4 border border-stone-700 hover:border-gold-500/50 text-stone-300 hover:text-gold-400 font-cinzel text-base tracking-widest rounded transition-all">
                    SIGN IN
                </a>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-24 px-8 max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <div class="text-gold-400 font-cinzel text-xs tracking-[0.4rem] mb-3">✦ FEATURES ✦</div>
            <h2 class="font-cinzel font-bold text-4xl text-stone-100">Everything a DM Needs</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
            $features = [
                ['icon' => '⚔️', 'title' => 'AI Encounter Analyzer', 'desc' => 'GPT-powered analysis of your encounters — difficulty, TPK risk, tactical advice, and balancing recommendations.', 'color' => 'gold'],
                ['icon' => '🐉', 'title' => 'D&D 5e Compendium', 'desc' => 'Full access to 300+ monsters, 300+ spells, all classes, and equipment from the official D&D 5e API.', 'color' => 'crimson'],
                ['icon' => '📜', 'title' => 'Campaign Management', 'desc' => 'Create and manage your campaigns, track encounters, and manage your adventuring party.', 'color' => 'arcane'],
                ['icon' => '🧙', 'title' => 'Character Sheets', 'desc' => 'Full character management for players — track HP, inventory, spells, and ability scores.', 'color' => 'gold'],
                ['icon' => '🏪', 'title' => 'Creator Marketplace', 'desc' => 'Publish and monetize homebrew content — campaign packs, monsters, spells, and items.', 'color' => 'crimson'],
                ['icon' => '👥', 'title' => 'Multi-Role System', 'desc' => 'Separate roles for Admins, DMs, Players, and Creators — each with tailored features.', 'color' => 'arcane'],
            ];
            @endphp

            @foreach($features as $f)
            <div class="card-glow bg-stone-900/60 rounded-xl p-6">
                <div class="text-3xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-cinzel font-semibold text-stone-100 text-lg mb-2">{{ $f['title'] }}</h3>
                <p class="text-stone-500 text-sm leading-relaxed font-crimson text-base">{{ $f['desc'] }}</p>
            </div>
            @endforeach

        </div>
    </section>

    {{-- Tech Stack --}}
    <section class="py-16 px-8 border-t border-stone-800">
        <div class="max-w-4xl mx-auto text-center">
            <div class="text-stone-600 font-cinzel text-xs tracking-[0.4rem] mb-8">✦ BUILT WITH ✦</div>
            <div class="flex flex-wrap justify-center items-center gap-8 text-stone-500">
                @foreach(['Laravel 12', 'Blade + Alpine.js', 'Tailwind CSS', 'D&D 5e API', 'OpenAI GPT', 'MySQL'] as $tech)
                    <span class="font-cinzel text-sm tracking-widest hover:text-gold-400 transition-colors">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-24 px-8 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="font-cinzel font-black text-5xl mb-4">
                <span class="text-gradient">Ready to Roll?</span>
            </h2>
            <p class="text-stone-500 font-crimson text-xl italic mb-8">Join thousands of Dungeon Masters already using EasyDM.</p>
            <a href="{{ route('register') }}"
               class="inline-block px-10 py-4 bg-crimson-600 hover:bg-crimson-500 text-stone-100 font-cinzel font-bold text-base tracking-widest rounded transition-all hover:shadow-xl hover:shadow-crimson-500/30 hover:-translate-y-0.5">
                ✦ CREATE FREE ACCOUNT ✦
            </a>
        </div>
    </section>

    <footer class="py-6 text-center text-stone-700 font-cinzel text-xs tracking-widest border-t border-stone-800">
        ✦ EASYDM &copy; {{ date('Y') }} — ALL RIGHTS RESERVED ✦
    </footer>

</body>
</html>
