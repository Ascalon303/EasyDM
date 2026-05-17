@extends('layouts.app')
@section('title', $spell['name'])
@section('page-title', $spell['name'])
@section('breadcrumb', 'Spells / ' . $spell['name'])

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    {{-- Header --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $spell['name'] }}</h2>
                <p class="text-arcane-400/80 font-crimson italic text-lg mt-1">
                    @if(isset($spell['level']))
                        {{ $spell['level'] == 0 ? 'Cantrip' : 'Level ' . $spell['level'] . ' spell' }}
                    @endif
                    @if(!empty($spell['school']['name'])) — {{ $spell['school']['name'] }} @endif
                </p>
            </div>
            <div class="text-4xl">✨</div>
        </div>
    </div>

    {{-- Casting info --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
            @foreach([
                ['label' => 'Casting Time', 'value' => $spell['casting_time'] ?? '—'],
                ['label' => 'Range',        'value' => $spell['range'] ?? '—'],
                ['label' => 'Duration',     'value' => $spell['duration'] ?? '—'],
                ['label' => 'Components',   'value' => implode(', ', $spell['components'] ?? [])],
            ] as $item)
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">{{ strtoupper($item['label']) }}</div>
                <div class="text-stone-100 text-sm font-cinzel">{{ $item['value'] ?: '—' }}</div>
            </div>
            @endforeach
        </div>

        @if(!empty($spell['material']))
        <div class="bg-stone-800/40 rounded-lg p-3 text-sm text-stone-400 font-crimson italic">
            <span class="font-cinzel text-xs text-stone-500 not-italic">MATERIAL: </span>{{ $spell['material'] }}
        </div>
        @endif

        <div class="flex gap-4 mt-4 text-xs font-cinzel">
            @if(!empty($spell['ritual']))
                <span class="px-2 py-1 bg-arcane-500/20 border border-arcane-500/30 text-arcane-400 rounded">RITUAL</span>
            @endif
            @if(!empty($spell['concentration']))
                <span class="px-2 py-1 bg-gold-500/20 border border-gold-500/30 text-gold-400 rounded">CONCENTRATION</span>
            @endif
        </div>
    </div>

    {{-- Description --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ DESCRIPTION ✦</div>
        <div class="space-y-3">
            @foreach($spell['desc'] ?? [] as $para)
            <p class="text-stone-300 font-crimson text-lg leading-relaxed">{{ $para }}</p>
            @endforeach
        </div>

        @if(!empty($spell['higher_level']))
        <div class="mt-5 pt-5 border-t border-stone-800">
            <div class="text-gold-400 font-cinzel text-xs tracking-widest mb-2">AT HIGHER LEVELS</div>
            @foreach($spell['higher_level'] as $para)
            <p class="text-stone-400 font-crimson text-base leading-relaxed">{{ $para }}</p>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Classes --}}
    @if(!empty($spell['classes']))
    <div class="deco-border bg-stone-900 rounded-xl p-5">
        <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">AVAILABLE TO</div>
        <div class="flex flex-wrap gap-2">
            @foreach($spell['classes'] as $class)
            <a href="{{ route('classes.show', $class['index']) }}"
               class="px-3 py-1 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs rounded transition-all">
                {{ $class['name'] }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
