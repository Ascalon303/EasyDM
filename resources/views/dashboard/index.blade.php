@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Welcome banner --}}
    <div class="deco-border bg-stone-900/60 rounded-xl p-6 flex items-center justify-between">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-gold-400">Welcome back, {{ $user->name }}</h2>
            <p class="text-stone-500 font-crimson italic mt-1 text-lg">
                @php
                    $greetings = ['The dice await your command.', 'May your rolls be ever in your favor.', 'A new session begins.', 'Adventure calls, Dungeon Master.'];
                    echo $greetings[array_rand($greetings)];
                @endphp
            </p>
        </div>
        <div class="hidden md:block text-6xl opacity-20 font-cinzel text-gold-400">⚔</div>
    </div>

    {{-- ADMIN DASHBOARD --}}
    @if($user->isAdmin())

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
            $statCards = [
                ['label' => 'Total Users',     'value' => $stats['total_users'],     'icon' => '👥', 'color' => 'text-gold-400'],
                ['label' => 'Campaigns',       'value' => $stats['total_campaigns'], 'icon' => '📜', 'color' => 'text-arcane-400'],
                ['label' => 'Encounters',      'value' => $stats['total_encounters'],'icon' => '⚔️', 'color' => 'text-crimson-400'],
                ['label' => 'Creator Content', 'value' => $stats['total_contents'],  'icon' => '🏪', 'color' => 'text-green-400'],
            ];
            @endphp

            @foreach($statCards as $card)
            <div class="card-hover bg-stone-900 rounded-xl p-5">
                <div class="text-2xl mb-2">{{ $card['icon'] }}</div>
                <div class="text-3xl font-cinzel font-bold {{ $card['color'] }}">{{ $card['value'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">{{ strtoupper($card['label']) }}</div>
            </div>
            @endforeach
        </div>

        <div>
            <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ RECENT USERS</h3>
            <div class="bg-stone-900 rounded-xl deco-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-stone-800">
                            <th class="text-left px-5 py-3 text-stone-500 font-cinzel text-xs tracking-widest">NAME</th>
                            <th class="text-left px-5 py-3 text-stone-500 font-cinzel text-xs tracking-widest">EMAIL</th>
                            <th class="text-left px-5 py-3 text-stone-500 font-cinzel text-xs tracking-widest">ROLE</th>
                            <th class="text-left px-5 py-3 text-stone-500 font-cinzel text-xs tracking-widest">JOINED</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_users'] as $u)
                        <tr class="border-b border-stone-800/50 hover:bg-stone-800/30 transition-colors">
                            <td class="px-5 py-3 text-stone-200">{{ $u->name }}</td>
                            <td class="px-5 py-3 text-stone-400">{{ $u->email }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-cinzel px-2 py-1 rounded border border-gold-500/30 text-gold-400">{{ strtoupper($u->role) }}</span>
                            </td>
                            <td class="px-5 py-3 text-stone-500 text-xs">{{ $u->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    {{-- DM DASHBOARD --}}
    @elseif($user->isDM())

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['label' => 'Campaigns',  'value' => $stats['total_campaigns'],  'icon' => '📜', 'color' => 'text-gold-400',    'route' => route('campaigns.index')],
                ['label' => 'Encounters', 'value' => $stats['total_encounters'], 'icon' => '⚔️', 'color' => 'text-crimson-400', 'route' => route('encounters.index')],
                ['label' => 'New Campaign','value' => '+',                       'icon' => '✦',  'color' => 'text-arcane-400',  'route' => route('campaigns.create')],
            ] as $card)
            <a href="{{ $card['route'] }}" class="card-hover bg-stone-900 rounded-xl p-5 block">
                <div class="text-2xl mb-2">{{ $card['icon'] }}</div>
                <div class="text-3xl font-cinzel font-bold {{ $card['color'] }}">{{ $card['value'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">{{ strtoupper($card['label']) }}</div>
            </a>
            @endforeach
        </div>

        {{-- Recent Campaigns --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-cinzel text-gold-400 text-sm tracking-widest">✦ RECENT CAMPAIGNS</h3>
                <a href="{{ route('campaigns.create') }}" class="text-xs font-cinzel text-stone-500 hover:text-gold-400 transition-colors">+ NEW</a>
            </div>
            @if($stats['campaigns']->count())
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($stats['campaigns'] as $campaign)
                <a href="{{ route('campaigns.show', $campaign) }}" class="card-hover bg-stone-900 rounded-xl p-5 block">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-cinzel text-stone-100 font-semibold">{{ $campaign->title }}</h4>
                        <span class="text-xs px-2 py-0.5 rounded font-cinzel
                            @if($campaign->status === 'active') bg-green-900/40 text-green-400
                            @elseif($campaign->status === 'planning') bg-yellow-900/40 text-yellow-400
                            @else bg-stone-800 text-stone-400 @endif">
                            {{ strtoupper($campaign->status) }}
                        </span>
                    </div>
                    <p class="text-stone-500 text-sm parchment line-clamp-2">{{ $campaign->description ?? 'No description.' }}</p>
                    <div class="mt-3 text-xs text-stone-600 font-cinzel tracking-wider">{{ $campaign->encounters_count }} ENCOUNTERS</div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-stone-900 rounded-xl p-8 text-center deco-border">
                <div class="text-4xl mb-3 opacity-40">📜</div>
                <p class="text-stone-500 font-crimson italic text-lg">No campaigns yet. Start your first adventure!</p>
                <a href="{{ route('campaigns.create') }}" class="inline-block mt-4 px-5 py-2 bg-gold-500 text-stone-900 font-cinzel text-xs font-bold tracking-widest rounded transition-all hover:bg-gold-400">
                    CREATE CAMPAIGN
                </a>
            </div>
            @endif
        </div>

    {{-- PLAYER DASHBOARD --}}
    @elseif($user->isPlayer())

        <div class="grid grid-cols-2 gap-4">
            <div class="card-hover bg-stone-900 rounded-xl p-5">
                <div class="text-3xl font-cinzel font-bold text-gold-400">{{ $stats['total_characters'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">CHARACTERS</div>
            </div>
            <div class="card-hover bg-stone-900 rounded-xl p-5">
                <div class="text-3xl font-cinzel font-bold text-arcane-400">{{ $stats['joined_campaigns'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">CAMPAIGNS JOINED</div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-cinzel text-gold-400 text-sm tracking-widest">✦ YOUR CHARACTERS</h3>
                <a href="{{ route('characters.create') }}" class="text-xs font-cinzel text-stone-500 hover:text-gold-400 transition-colors">+ NEW</a>
            </div>
            @if($stats['characters']->count())
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($stats['characters'] as $char)
                <a href="{{ route('characters.show', $char) }}" class="card-hover bg-stone-900 rounded-xl p-5 block">
                    <div class="font-cinzel text-stone-100 font-semibold">{{ $char->name }}</div>
                    <div class="text-stone-500 text-sm mt-1">Lv.{{ $char->level }} {{ $char->race }} {{ $char->class }}</div>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="flex-1 bg-stone-800 rounded-full h-1.5">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width:{{ $char->hp_percentage }}%"></div>
                        </div>
                        <span class="text-xs text-stone-500">{{ $char->current_hp }}/{{ $char->max_hp }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-stone-900 rounded-xl p-8 text-center deco-border">
                <div class="text-4xl mb-3 opacity-40">⚔️</div>
                <p class="text-stone-500 font-crimson italic text-lg">Create your first character to begin!</p>
                <a href="{{ route('characters.create') }}" class="inline-block mt-4 px-5 py-2 bg-gold-500 text-stone-900 font-cinzel text-xs font-bold tracking-widest rounded hover:bg-gold-400 transition-all">
                    CREATE CHARACTER
                </a>
            </div>
            @endif
        </div>

    {{-- CREATOR DASHBOARD --}}
    @elseif($user->isCreator())

        <div class="grid grid-cols-3 gap-4">
            <div class="card-hover bg-stone-900 rounded-xl p-5">
                <div class="text-3xl font-cinzel font-bold text-gold-400">{{ $stats['total_contents'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">PUBLISHED</div>
            </div>
            <div class="card-hover bg-stone-900 rounded-xl p-5">
                <div class="text-3xl font-cinzel font-bold text-arcane-400">{{ number_format($stats['total_downloads']) }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">DOWNLOADS</div>
            </div>
            <a href="{{ route('creator-content.create') }}" class="card-hover bg-stone-900 rounded-xl p-5 flex flex-col items-center justify-center text-center">
                <div class="text-3xl font-cinzel font-bold text-crimson-400">+</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">PUBLISH</div>
            </a>
        </div>

        <div>
            <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ YOUR CONTENT</h3>
            @if($stats['contents']->count())
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($stats['contents'] as $content)
                <a href="{{ route('creator-content.show', $content) }}" class="card-hover bg-stone-900 rounded-xl p-5 block">
                    <div class="flex items-start justify-between">
                        <h4 class="font-cinzel text-stone-100 font-semibold">{{ $content->title }}</h4>
                        <span class="text-xs text-gold-400 font-cinzel">${{ $content->price }}</span>
                    </div>
                    <div class="text-xs font-cinzel text-stone-500 tracking-wider mt-2">{{ strtoupper(str_replace('_',' ',$content->type)) }}</div>
                    <div class="text-xs text-stone-600 mt-2">{{ $content->download_count }} downloads</div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-stone-900 rounded-xl p-8 text-center deco-border">
                <p class="text-stone-500 font-crimson italic text-lg">No content published yet.</p>
            </div>
            @endif
        </div>

    @endif

    {{-- Quick links to compendium --}}
    <div>
        <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ D&D COMPENDIUM</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach([
                ['label' => 'Monsters',   'icon' => '🐉', 'route' => route('monsters.index')],
                ['label' => 'Spells',     'icon' => '✨', 'route' => route('spells.index')],
                ['label' => 'Classes',    'icon' => '📖', 'route' => route('classes.index')],
                ['label' => 'Equipment',  'icon' => '🛡️', 'route' => route('equipment.index')],
            ] as $link)
            <a href="{{ $link['route'] }}" class="card-hover bg-stone-900 rounded-xl p-4 flex items-center gap-3">
                <span class="text-2xl">{{ $link['icon'] }}</span>
                <span class="font-cinzel text-stone-300 text-sm font-semibold">{{ $link['label'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

</div>
@endsection
