@extends('layouts.app')
@section('title', $character->name)
@section('page-title', $character->name)
@section('breadcrumb', 'Characters / ' . $character->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-start justify-between gap-4">
        <div>
            <h2 class="font-cinzel text-3xl font-black text-stone-100">{{ $character->name }}</h2>
            <p class="text-gold-400/80 font-cinzel text-lg mt-1">
                Level {{ $character->level }} {{ $character->race }} {{ $character->class }}
            </p>
            @if($character->background)
            <p class="text-stone-500 font-crimson italic mt-1">{{ $character->background }}</p>
            @endif
        </div>
        <div class="flex gap-2 shrink-0">
            <a href="{{ route('characters.edit', $character) }}"
               class="px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                EDIT
            </a>
        </div>
    </div>

    {{-- Combat row --}}
    <div class="grid grid-cols-3 gap-4">

        {{-- HP --}}
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">HIT POINTS</div>
            <div class="text-4xl font-cinzel font-black
                @if($character->hp_percentage > 60) text-green-400
                @elseif($character->hp_percentage > 30) text-yellow-400
                @else text-red-400 @endif">
                {{ $character->current_hp }}
            </div>
            <div class="text-stone-500 text-sm font-cinzel mt-0.5">/ {{ $character->max_hp }}</div>
            <div class="mt-3 w-full bg-stone-800 rounded-full h-2">
                <div class="h-2 rounded-full
                    @if($character->hp_percentage > 60) bg-green-500
                    @elseif($character->hp_percentage > 30) bg-yellow-500
                    @else bg-red-500 @endif"
                    style="width:{{ $character->hp_percentage }}%">
                </div>
            </div>
        </div>

        {{-- AC --}}
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">ARMOR CLASS</div>
            <div class="text-4xl font-cinzel font-black text-gold-400">{{ $character->armor_class }}</div>
            <div class="text-stone-500 text-xs font-cinzel mt-2">AC</div>
        </div>

        {{-- Level --}}
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">LEVEL</div>
            <div class="text-4xl font-cinzel font-black text-arcane-400">{{ $character->level }}</div>
            <div class="text-stone-500 text-xs font-cinzel mt-2">
                Prof. Bonus: +{{ ceil($character->level / 4) + 1 }}
            </div>
        </div>
    </div>

    {{-- Ability Scores --}}
    @if(!empty($character->ability_scores))
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-5">✦ ABILITY SCORES ✦</div>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
            @foreach(['str'=>'STRENGTH','dex'=>'DEXTERITY','con'=>'CONSTITUTION','int'=>'INTELLIGENCE','wis'=>'WISDOM','cha'=>'CHARISMA'] as $key => $label)
            @php
                $val = $character->ability_scores[$key] ?? 10;
                $mod = floor(($val - 10) / 2);
                $modStr = ($mod >= 0 ? '+' : '') . $mod;
            @endphp
            <div class="bg-stone-800/60 rounded-xl p-4 text-center border border-stone-700/50">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">{{ strtoupper(substr($key,0,3)) }}</div>
                <div class="text-gold-400 text-3xl font-cinzel font-black">{{ $val }}</div>
                <div class="text-stone-300 text-sm font-cinzel mt-1 font-bold">{{ $modStr }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Notes --}}
    @if($character->notes)
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ NOTES ✦</div>
        <p class="text-stone-400 font-crimson text-lg leading-relaxed">{{ $character->notes }}</p>
    </div>
    @endif

    {{-- Campaign --}}
    @if($character->campaign)
    <div class="deco-border bg-stone-900 rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">CAMPAIGN</div>
            <div class="font-cinzel text-gold-400 font-semibold">{{ $character->campaign->title }}</div>
        </div>
        <a href="{{ route('campaigns.show', $character->campaign) }}"
           class="text-xs px-3 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel rounded-lg transition-all">
            VIEW CAMPAIGN
        </a>
    </div>
    @endif

</div>
@endsection
