@extends('layouts.app')
@section('title', $monster['name'])
@section('page-title', $monster['name'])
@section('breadcrumb', 'Monsters / ' . $monster['name'])

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="grid md:grid-cols-3 gap-6">

        {{-- Main stat block --}}
        <div class="md:col-span-2 space-y-5">

            {{-- Header --}}
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $monster['name'] }}</h2>
                        <p class="text-gold-400/70 font-crimson italic text-lg mt-1">
                            {{ $monster['size'] ?? '' }} {{ $monster['type'] ?? '' }}
                            @if(!empty($monster['subtype'])) ({{ $monster['subtype'] }}) @endif
                            @if(!empty($monster['alignment'])) • {{ $monster['alignment'] }} @endif
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-cinzel font-black text-crimson-400">CR {{ $monster['challenge_rating'] ?? '?' }}</div>
                        <div class="text-stone-600 text-xs font-cinzel tracking-wider">{{ number_format($monster['xp'] ?? 0) }} XP</div>
                    </div>
                </div>
            </div>

            {{-- Core Stats --}}
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="grid grid-cols-3 gap-4 mb-5">
                    @foreach([
                        ['label' => 'Armor Class', 'value' => collect($monster['armor_class'] ?? [])->pluck('value')->first() ?? '—'],
                        ['label' => 'Hit Points', 'value' => ($monster['hit_points'] ?? '—') . ' (' . ($monster['hit_points_roll'] ?? '—') . ')'],
                        ['label' => 'Speed', 'value' => collect($monster['speed'] ?? [])->map(fn($v,$k) => "$k $v")->implode(', ') ?: '—'],
                    ] as $stat)
                    <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                        <div class="text-stone-400 text-xs font-cinzel tracking-widest mb-1">{{ strtoupper($stat['label']) }}</div>
                        <div class="text-stone-100 font-cinzel font-semibold text-sm">{{ $stat['value'] }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Ability Scores --}}
                <div class="rune-divider mb-4">✦ ABILITIES ✦</div>
                <div class="grid grid-cols-6 gap-2">
                    @foreach(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'] as $ability)
                    @php
                        $val = $monster[$ability] ?? 10;
                        $mod = floor(($val - 10) / 2);
                        $modStr = ($mod >= 0 ? '+' : '') . $mod;
                    @endphp
                    <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                        <div class="text-gold-400 text-xs font-cinzel tracking-widest">{{ strtoupper(substr($ability,0,3)) }}</div>
                        <div class="text-stone-100 font-cinzel font-bold text-lg">{{ $val }}</div>
                        <div class="text-stone-400 text-xs">({{ $modStr }})</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Special Abilities --}}
            @if(!empty($monster['special_abilities']))
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="rune-divider mb-4">✦ SPECIAL ABILITIES ✦</div>
                <div class="space-y-4">
                    @foreach($monster['special_abilities'] as $ability)
                    <div>
                        <div class="font-cinzel text-gold-400 text-sm font-semibold">{{ $ability['name'] }}</div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed">
                            {{ collect($ability['desc'] ?? [])->join(' ') ?: ($ability['desc'] ?? '') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Actions --}}
            @if(!empty($monster['actions']))
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="rune-divider mb-4">✦ ACTIONS ✦</div>
                <div class="space-y-4">
                    @foreach($monster['actions'] as $action)
                    <div>
                        <div class="font-cinzel text-crimson-400 text-sm font-semibold">{{ $action['name'] }}</div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed">{{ $action['desc'] ?? '' }}</p>
                        @if(!empty($action['attack_bonus']))
                            <div class="text-xs text-stone-600 mt-1 font-cinzel">Attack Bonus: +{{ $action['attack_bonus'] }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Legendary Actions --}}
            @if(!empty($monster['legendary_actions']))
            <div class="deco-border bg-stone-900 rounded-xl p-6 border-arcane-500/20">
                <div class="rune-divider mb-4">✦ LEGENDARY ACTIONS ✦</div>
                <div class="space-y-4">
                    @foreach($monster['legendary_actions'] as $action)
                    <div>
                        <div class="font-cinzel text-arcane-400 text-sm font-semibold">{{ $action['name'] }}</div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed">{{ $action['desc'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar: Traits --}}
        <div class="space-y-4">

            <div class="deco-border bg-stone-900 rounded-xl p-5">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-4">TRAITS</div>
                <div class="space-y-3 text-sm">

                    @if(!empty($monster['proficiency_bonus']))
                    <div class="flex justify-between">
                        <span class="text-stone-500 font-cinzel text-xs">PROFICIENCY</span>
                        <span class="text-gold-400 font-cinzel">+{{ $monster['proficiency_bonus'] }}</span>
                    </div>
                    @endif

                    @if(!empty($monster['senses']))
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">SENSES</div>
                        <div class="text-stone-300 text-xs">
                            @foreach($monster['senses'] as $sense => $val)
                                <div>{{ ucfirst(str_replace('_',' ',$sense)) }}: {{ $val }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($monster['languages']))
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">LANGUAGES</div>
                        <div class="text-stone-300 text-xs">{{ $monster['languages'] }}</div>
                    </div>
                    @endif

                    @if(!empty($monster['damage_immunities']))
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">IMMUNITIES</div>
                        <div class="flex flex-wrap gap-1">
                            @foreach($monster['damage_immunities'] as $dmg)
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel">{{ is_array($dmg) ? ($dmg['name'] ?? '') : $dmg }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($monster['damage_resistances']))
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">RESISTANCES</div>
                        <div class="flex flex-wrap gap-1">
                            @foreach($monster['damage_resistances'] as $dmg)
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel">{{ is_array($dmg) ? ($dmg['name'] ?? '') : $dmg }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($monster['condition_immunities']))
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">CONDITION IMMUNITIES</div>
                        <div class="flex flex-wrap gap-1">
                            @foreach($monster['condition_immunities'] as $cond)
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel">{{ is_array($cond) ? ($cond['name'] ?? '') : $cond }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Use in encounter --}}
            <a href="{{ route('encounters.create') }}"
               class="block w-full text-center py-3 border border-gold-500/30 hover:border-gold-500/60 text-gold-400 hover:text-gold-300 font-cinzel text-xs tracking-widest rounded-xl transition-all">
                ✦ USE IN ENCOUNTER
            </a>

        </div>
    </div>

</div>
@endsection
