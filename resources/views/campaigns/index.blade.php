@extends('layouts.app')
@section('title', 'Campaigns')
@section('page-title', 'Campaigns')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100">Your Campaigns</h2>
            <p class="text-stone-500 font-crimson italic mt-1">{{ $campaigns->total() }} campaigns in your realm</p>
        </div>
        <a href="{{ route('campaigns.create') }}"
           class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
            ✦ NEW CAMPAIGN
        </a>
    </div>

    @if($campaigns->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($campaigns as $campaign)
        <div class="card-hover bg-stone-900 rounded-xl overflow-hidden">
            {{-- Header --}}
            <div class="p-5 border-b border-stone-800">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-cinzel text-stone-100 font-semibold text-lg leading-tight">{{ $campaign->title }}</h3>
                    <span class="text-xs px-2 py-0.5 rounded font-cinzel shrink-0
                        @if($campaign->status === 'active')    bg-green-900/40 text-green-400 border border-green-500/20
                        @elseif($campaign->status === 'planning') bg-yellow-900/40 text-yellow-400 border border-yellow-500/20
                        @elseif($campaign->status === 'paused')  bg-orange-900/40 text-orange-400 border border-orange-500/20
                        @else bg-stone-800 text-stone-400 border border-stone-700 @endif">
                        {{ strtoupper($campaign->status) }}
                    </span>
                </div>
                @if($campaign->world_name)
                    <div class="text-gold-400/60 text-xs font-cinzel tracking-widest mt-1">🌍 {{ $campaign->world_name }}</div>
                @endif
            </div>

            {{-- Body --}}
            <div class="p-5">
                <p class="text-stone-500 text-sm font-crimson leading-relaxed line-clamp-3">
                    {{ $campaign->description ?? 'No description provided.' }}
                </p>
            </div>

            {{-- Footer --}}
            <div class="px-5 pb-5 flex items-center justify-between">
                <div class="text-xs text-stone-600 font-cinzel tracking-wider">
                    ⚔ {{ $campaign->encounters_count }} ENCOUNTERS
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="text-xs px-3 py-1.5 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 rounded font-cinzel tracking-wider transition-all">
                        VIEW
                    </a>
                    <a href="{{ route('campaigns.edit', $campaign) }}"
                       class="text-xs px-3 py-1.5 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 rounded font-cinzel tracking-wider transition-all">
                        EDIT
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $campaigns->links() }}</div>

    @else
    <div class="text-center py-20 deco-border bg-stone-900/40 rounded-xl">
        <div class="text-6xl mb-4 opacity-20">📜</div>
        <h3 class="font-cinzel text-xl text-stone-400 mb-2">No campaigns yet</h3>
        <p class="text-stone-600 font-crimson italic mb-6">Every legend must begin somewhere.</p>
        <a href="{{ route('campaigns.create') }}"
           class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
            CREATE YOUR FIRST CAMPAIGN
        </a>
    </div>
    @endif

</div>
@endsection
