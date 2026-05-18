@extends('layouts.app')
@section('title', 'Browse Campaigns')
@section('page-title', 'Browse Campaigns')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-900/40 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg font-crimson">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-900/40 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg font-crimson">
            {{ session('error') }}
        </div>
    @endif

    {{-- Campaigns I've Joined --}}
    @if($joinedCampaigns->count())
    <div>
        <h2 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ MY JOINED CAMPAIGNS</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($joinedCampaigns as $c)
            <div class="bg-stone-900 rounded-xl p-5 deco-border">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-cinzel text-stone-100 font-semibold">{{ $c->title }}</h3>
                    <span class="text-xs text-stone-500 font-cinzel">{{ $c->encounters_count }} encounters</span>
                </div>
                <p class="text-stone-400 font-crimson text-sm mb-4">{{ Str::limit($c->description, 80) }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-stone-500">DM: {{ $c->user->name }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('campaigns.player-view', $c) }}"
                           class="text-xs text-gold-400 hover:text-gold-300 font-cinzel border border-gold-500/30 px-3 py-1 rounded transition-all">
                            VIEW
                        </a>
                        <form method="POST" action="{{ route('campaigns.leave', $c) }}">
                            @csrf @method('DELETE')
                            <button class="text-xs text-crimson-500 hover:text-crimson-400 font-cinzel border border-crimson-500/30 px-3 py-1 rounded transition-all"
                                    onclick="return confirm('Leave this campaign?')">
                                LEAVE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Available Campaigns --}}
    <div>
        <h2 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ AVAILABLE CAMPAIGNS</h2>

        @if($campaigns->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($campaigns as $campaign)
            <div class="bg-stone-900 rounded-xl p-5 deco-border">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-cinzel text-stone-100 font-semibold">{{ $campaign->title }}</h3>
                    <span class="text-xs px-2 py-0.5 rounded bg-green-900/40 text-green-400 font-cinzel">
                        {{ strtoupper($campaign->status) }}
                    </span>
                </div>
                @if($campaign->world_name)
                    <p class="text-gold-500/70 text-xs font-cinzel mb-2">🗺 {{ $campaign->world_name }}</p>
                @endif
                <p class="text-stone-400 font-crimson text-sm mb-4">
                    {{ $campaign->description ? Str::limit($campaign->description, 100) : 'No description.' }}
                </p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-stone-500">
                        DM: {{ $campaign->user->name }} · {{ $campaign->players_count }} players
                    </span>
                    <form method="POST" action="{{ route('campaigns.join', $campaign) }}">
                        @csrf
                        <button class="text-xs bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold px-3 py-1 rounded transition-all">
                            JOIN
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $campaigns->links() }}</div>

        @else
        <div class="bg-stone-900 rounded-xl p-12 text-center deco-border">
            <p class="text-stone-500 font-crimson text-lg">No campaigns available to join right now.</p>
        </div>
        @endif
    </div>

</div>
@endsection