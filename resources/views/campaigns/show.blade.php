@extends('layouts.app')
@section('title', $campaign->title)
@section('page-title', $campaign->title)
@section('breadcrumb', 'Campaigns / ' . $campaign->title)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $campaign->title }}</h2>
                <span class="text-xs px-2 py-0.5 rounded font-cinzel
                    @if($campaign->status === 'active') bg-green-900/40 text-green-400 border border-green-500/20
                    @elseif($campaign->status === 'planning') bg-yellow-900/40 text-yellow-400 border border-yellow-500/20
                    @else bg-stone-800 text-stone-400 border border-stone-700 @endif">
                    {{ strtoupper($campaign->status) }}
                </span>
            </div>
            @if($campaign->world_name)
                <div class="text-gold-400/60 text-sm font-cinzel tracking-widest">🌍 {{ $campaign->world_name }}</div>
            @endif
            @if($campaign->description)
                <p class="text-stone-400 font-crimson text-lg italic mt-3">{{ $campaign->description }}</p>
            @endif
        </div>
        <div class="flex gap-2 shrink-0">
            <a href="{{ route('campaigns.edit', $campaign) }}"
               class="px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                EDIT
            </a>
            <a href="{{ route('encounters.create', ['campaign_id' => $campaign->id]) }}"
               class="px-4 py-2 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-xs tracking-widest rounded-lg transition-all">
                + ENCOUNTER
            </a>
        </div>
    </div>

    {{-- Encounters --}}
    <div>
        <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ ENCOUNTERS ({{ $encounters->count() }})</h3>

        @if($encounters->count())
        <div class="space-y-3">
            @foreach($encounters as $encounter)
            <a href="{{ route('encounters.show', $encounter) }}" class="card-hover bg-stone-900 rounded-xl p-4 flex items-center justify-between block">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-800 flex items-center justify-center text-xl">⚔️</div>
                    <div>
                        <div class="font-cinzel text-stone-100 font-semibold">{{ $encounter->name }}</div>
                        <div class="text-stone-500 text-xs font-cinzel tracking-wider mt-0.5">
                            {{ count($encounter->monster_data ?? []) }} monster types •
                            {{ count($encounter->party_data ?? []) }} party members
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if($encounter->difficulty)
                        <span class="text-xs font-cinzel px-2 py-1 rounded border
                            @if($encounter->difficulty === 'easy')   border-green-500/30 text-green-400
                            @elseif($encounter->difficulty === 'medium') border-yellow-500/30 text-yellow-400
                            @elseif($encounter->difficulty === 'hard')   border-orange-500/30 text-orange-400
                            @else border-red-500/30 text-red-400 @endif">
                            {{ strtoupper($encounter->difficulty) }}
                        </span>
                    @endif
                    <svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 deco-border bg-stone-900/40 rounded-xl">
            <div class="text-4xl mb-3 opacity-20">⚔️</div>
            <p class="text-stone-500 font-crimson italic">No encounters yet. Create your first one!</p>
        </div>
        @endif
    </div>

</div>
@endsection
