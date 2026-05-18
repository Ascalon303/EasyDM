@extends('layouts.app')
@section('title', $campaign->title)
@section('page-title', $campaign->title)
@section('breadcrumb', 'Browse Campaigns / ' . $campaign->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-900/40 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg font-crimson">
            {{ session('success') }}
        </div>
    @endif

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
            <div class="text-stone-500 text-xs font-cinzel mt-3">DM: {{ $campaign->user->name }}</div>
        </div>

        {{-- Leave button --}}
        <form method="POST" action="{{ route('campaigns.leave', $campaign) }}" class="shrink-0">
            @csrf @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Are you sure you want to leave this campaign?')"
                    class="px-4 py-2 border border-crimson-500/40 hover:border-crimson-400 text-crimson-500 hover:text-crimson-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                LEAVE CAMPAIGN
            </button>
        </form>
    </div>

    {{-- Encounters (read-only) --}}
    <div>
        <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ ENCOUNTERS ({{ $encounters->count() }})</h3>

        @if($encounters->count())
        <div class="space-y-3">
            @foreach($encounters as $encounter)
            <div class="bg-stone-900 rounded-xl p-4 flex items-center justify-between deco-border">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-800 flex items-center justify-center text-xl">⚔️</div>
                    <div>
                        <div class="font-cinzel text-stone-100 font-semibold">{{ $encounter->name }}</div>
                        <div class="text-stone-500 text-xs font-cinzel tracking-wider mt-0.5">
                            {{ count($encounter->monster_data ?? []) }} monster types ·
                            {{ count($encounter->party_data ?? []) }} party members
                        </div>
                    </div>
                </div>
                @if($encounter->difficulty)
                    <span class="text-xs font-cinzel px-2 py-1 rounded border
                        @if($encounter->difficulty === 'easy')   border-green-500/30 text-green-400
                        @elseif($encounter->difficulty === 'medium') border-yellow-500/30 text-yellow-400
                        @elseif($encounter->difficulty === 'hard')   border-orange-500/30 text-orange-400
                        @else border-red-500/30 text-red-400 @endif">
                        {{ strtoupper($encounter->difficulty) }}
                    </span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 deco-border bg-stone-900/40 rounded-xl">
            <div class="text-4xl mb-3 opacity-20">⚔️</div>
            <p class="text-stone-500 font-crimson italic">No encounters added yet.</p>
        </div>
        @endif
    </div>

    {{-- Back --}}
    <div>
        <a href="{{ route('campaigns.browse') }}"
           class="text-stone-500 hover:text-gold-400 font-cinzel text-xs tracking-widest transition-all">
            ← BACK TO BROWSE
        </a>
    </div>

</div>
@endsection