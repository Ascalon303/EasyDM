@extends('layouts.app')
@section('title', $item['name'])
@section('page-title', $item['name'])
@section('breadcrumb', 'Equipment / ' . $item['name'])

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $item['name'] }}</h2>
                <p class="text-gold-400/70 font-crimson italic text-lg mt-1">
                    {{ $item['equipment_category']['name'] ?? '' }}
                    @if(!empty($item['weapon_category'])) — {{ $item['weapon_category'] }} @endif
                    @if(!empty($item['armor_category'])) — {{ $item['armor_category'] }} @endif
                </p>
            </div>
            <div class="text-4xl">⚔️</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

            @if(!empty($item['cost']))
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">COST</div>
                <div class="text-gold-400 font-cinzel font-bold">{{ $item['cost']['quantity'] }} {{ strtoupper($item['cost']['unit']) }}</div>
            </div>
            @endif

            @if(!empty($item['weight']))
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">WEIGHT</div>
                <div class="text-stone-100 font-cinzel font-bold">{{ $item['weight'] }} lb</div>
            </div>
            @endif

            @if(!empty($item['armor_class']))
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">ARMOR CLASS</div>
                <div class="text-crimson-400 font-cinzel font-bold">{{ $item['armor_class']['base'] ?? '—' }}</div>
            </div>
            @endif

            @if(!empty($item['damage']))
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">DAMAGE</div>
                <div class="text-crimson-400 font-cinzel font-bold">
                    {{ $item['damage']['damage_dice'] ?? '—' }}
                    <span class="text-stone-500 text-xs">{{ $item['damage']['damage_type']['name'] ?? '' }}</span>
                </div>
            </div>
            @endif

            @if(!empty($item['range']))
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">RANGE</div>
                <div class="text-stone-100 font-cinzel text-sm">
                    {{ $item['range']['normal'] ?? '—' }}
                    @if(!empty($item['range']['long'])) / {{ $item['range']['long'] }} @endif
                    ft
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Properties --}}
    @if(!empty($item['properties']))
    <div class="deco-border bg-stone-900 rounded-xl p-5">
        <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">PROPERTIES</div>
        <div class="flex flex-wrap gap-2">
            @foreach($item['properties'] as $prop)
            <span class="px-3 py-1 bg-stone-800 border border-stone-700 text-arcane-400 font-cinzel text-xs rounded-lg">
                {{ $prop['name'] }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Description --}}
    @if(!empty($item['desc']))
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ DESCRIPTION ✦</div>
        @foreach($item['desc'] as $para)
        <p class="text-stone-300 font-crimson text-lg leading-relaxed mb-3">{{ $para }}</p>
        @endforeach
    </div>
    @endif

</div>
@endsection
