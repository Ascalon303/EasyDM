@extends('layouts.app')
@section('title', $encounter->name)
@section('page-title', $encounter->name)
@section('breadcrumb', 'Encounters / ' . $encounter->name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-center justify-between">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $encounter->name }}</h2>
            @if($encounter->campaign)
                <div class="text-gold-400/60 text-sm font-cinzel tracking-widest mt-1">
                    📜 {{ $encounter->campaign->title }}
                </div>
            @endif
        </div>
        <div class="flex items-center gap-3">
            @if($encounter->difficulty)
                <span class="text-sm font-cinzel px-4 py-1.5 rounded border
                    @if($encounter->difficulty === 'easy')   border-green-500/40 text-green-400 bg-green-900/20
                    @elseif($encounter->difficulty === 'medium') border-yellow-500/40 text-yellow-400 bg-yellow-900/20
                    @elseif($encounter->difficulty === 'hard')   border-orange-500/40 text-orange-400 bg-orange-900/20
                    @else border-red-500/40 text-red-400 bg-red-900/20 @endif">
                    {{ strtoupper($encounter->difficulty) }}
                </span>
            @endif
            <a href="{{ route('encounters.analyze', $encounter) }}"
               class="px-4 py-2 bg-arcane-600 hover:bg-arcane-500 text-stone-100 font-cinzel text-xs font-bold tracking-widest rounded-lg transition-all">
                🤖 RE-ANALYZE
            </a>
            <a href="{{ route('encounters.edit', $encounter) }}"
               class="px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                EDIT
            </a>
        </div>
    </div>

    {{-- Analysis stats --}}
    @if(isset($analysis))
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $statCards = [
            ['label' => 'Difficulty',    'value' => strtoupper($analysis['difficulty']),             'color' => match($analysis['difficulty']) { 'easy'=>'text-green-400','medium'=>'text-yellow-400','hard'=>'text-orange-400','deadly'=>'text-red-400',default=>'text-stone-400'}],
            ['label' => 'Adjusted XP',   'value' => number_format($analysis['adjusted_xp']) . ' XP', 'color' => 'text-gold-400'],
            ['label' => 'Total CR',      'value' => $analysis['total_cr'],                           'color' => 'text-arcane-400'],
            ['label' => 'Monster Count', 'value' => $analysis['monster_count'],                      'color' => 'text-crimson-400'],
        ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-stone-900 rounded-xl p-5 deco-border text-center">
            <div class="text-2xl font-cinzel font-bold {{ $card['color'] }}">{{ $card['value'] }}</div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">{{ strtoupper($card['label']) }}</div>
        </div>
        @endforeach
    </div>

    {{-- XP Thresholds --}}
    <div class="bg-stone-900 rounded-xl p-5 deco-border">
        <h3 class="font-cinzel text-stone-400 text-xs tracking-widest mb-4">✦ PARTY XP THRESHOLDS</h3>
        <div class="grid grid-cols-4 gap-3">
            @foreach(['easy' => 'text-green-400', 'medium' => 'text-yellow-400', 'hard' => 'text-orange-400', 'deadly' => 'text-red-400'] as $level => $color)
            <div class="text-center">
                <div class="text-lg font-cinzel font-bold {{ $color }}">
                    {{ number_format($analysis['party_thresholds'][$level]) }}
                </div>
                <div class="text-stone-600 text-xs font-cinzel tracking-widest mt-0.5">{{ strtoupper($level) }}</div>
                @if($analysis['adjusted_xp'] >= $analysis['party_thresholds'][$level])
                    <div class="text-xs text-gold-400 mt-0.5">✦</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Action economy + TPK --}}
    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-2">ACTION ECONOMY</div>
            <p class="text-stone-300 font-crimson text-lg">{{ $analysis['action_economy'] }}</p>
        </div>
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-2">TPK RISK</div>
            <p class="text-crimson-400 font-crimson text-lg">{{ $analysis['tpk_risk'] }}</p>
        </div>
    </div>
    @endif

    {{-- AI Analysis --}}
    @if($encounter->ai_analysis)
    <div class="bg-stone-900 rounded-xl p-6 deco-border">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-arcane-400 text-lg">🤖</span>
            <h3 class="font-cinzel text-arcane-400 text-sm tracking-widest">AI ENCOUNTER ANALYSIS</h3>
        </div>
        <div class="prose prose-invert prose-sm max-w-none">
            <div class="text-stone-300 font-crimson text-lg leading-relaxed prose prose-invert prose-sm max-w-none">
                {!! \Illuminate\Support\Str::markdown($encounter->ai_analysis) !!}
            </div>
        </div>
    </div>
    @endif

    {{-- Party & Monsters side by side --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- Party --}}
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <h3 class="font-cinzel text-gold-400 text-xs tracking-widest mb-4">⚔ ADVENTURING PARTY</h3>
            <div class="space-y-2">
                @foreach($encounter->party_data ?? [] as $member)
                <div class="flex items-center justify-between py-2 border-b border-stone-800/50">
                    <span class="text-stone-200 text-sm">{{ $member['name'] ?? 'Adventurer' }}</span>
                    <div class="text-right">
                        <span class="text-gold-400 font-cinzel text-xs">Lv.{{ $member['level'] ?? 1 }}</span>
                        <span class="text-stone-500 text-xs ml-2">{{ $member['class'] ?? '' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Monsters --}}
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <h3 class="font-cinzel text-crimson-400 text-xs tracking-widest mb-4">🐉 MONSTERS</h3>
            <div class="space-y-2">
                @foreach($encounter->monster_data ?? [] as $monster)
                <div class="flex items-center justify-between py-2 border-b border-stone-800/50">
                    <span class="text-stone-200 text-sm">{{ $monster['name'] ?? $monster['index'] }}</span>
                    <div class="flex items-center gap-3">
                        <span class="text-stone-500 text-xs">CR {{ $monster['challenge_rating'] ?? '?' }}</span>
                        <span class="text-crimson-400 font-cinzel text-xs">×{{ $monster['quantity'] ?? 1 }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
