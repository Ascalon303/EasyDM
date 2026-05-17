@extends('layouts.app')
@section('title', 'Create Character')
@section('page-title', 'Create Character')

@section('content')
<div class="max-w-3xl mx-auto" x-data="{ str: {{ old('str', $character->ability_scores['str'] ?? 10) }}, dex: {{ old('dex', $character->ability_scores['dex'] ?? 10) }}, con: {{ old('con', $character->ability_scores['con'] ?? 10) }}, int: {{ old('int', $character->ability_scores['int'] ?? 10) }}, wis: {{ old('wis', $character->ability_scores['wis'] ?? 10) }}, cha: {{ old('cha', $character->ability_scores['cha'] ?? 10) }} }">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ FORGE YOUR ADVENTURER</h2>

        <form method="POST" action="{{ isset($character) ? route('characters.update', $character) : route('characters.store') }}" class="space-y-6">
            @csrf
            @if(isset($character)) @method('PUT') @endif

            {{-- Basic Info --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CHARACTER NAME *</label>
                    <input type="text" name="name" value="{{ old('name', $character->name ?? '') }}" required
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none"
                           placeholder="Thorin Ironforge">
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">RACE *</label>
                    <select name="race" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        @foreach(['Human','Elf','Dwarf','Halfling','Gnome','Half-Elf','Half-Orc','Tiefling','Dragonborn','Aasimar','Tabaxi','Firbolg','Goliath','Kenku','Lizardfolk','Triton'] as $race)
                        <option {{ old('race', $character->race ?? 'Human') === $race ? 'selected' : '' }}>{{ $race }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CLASS *</label>
                    <select name="class" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        @foreach(['Barbarian','Bard','Cleric','Druid','Fighter','Monk','Paladin','Ranger','Rogue','Sorcerer','Warlock','Wizard'] as $cls)
                        <option {{ old('class', $character->class ?? 'Fighter') === $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">LEVEL *</label>
                    <input type="number" name="level" value="{{ old('level', $character->level ?? 1) }}" min="1" max="20" required
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">BACKGROUND</label>
                    <select name="background" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        <option value="">— None —</option>
                        @foreach(['Acolyte','Charlatan','Criminal','Entertainer','Folk Hero','Guild Artisan','Hermit','Noble','Outlander','Sage','Sailor','Soldier','Urchin'] as $bg)
                        <option {{ old('background', $character->background ?? '') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Combat Stats --}}
            <div>
                <div class="rune-divider mb-4">✦ COMBAT STATS ✦</div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">MAX HP *</label>
                        <input type="number" name="max_hp" value="{{ old('max_hp', $character->max_hp ?? 10) }}" min="1" required
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CURRENT HP *</label>
                        <input type="number" name="current_hp" value="{{ old('current_hp', $character->current_hp ?? 10) }}" min="0" required
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">ARMOR CLASS *</label>
                        <input type="number" name="armor_class" value="{{ old('armor_class', $character->armor_class ?? 10) }}" min="1" required
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                </div>
            </div>

            {{-- Ability Scores --}}
            <div>
                <div class="rune-divider mb-4">✦ ABILITY SCORES ✦</div>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                    @foreach([
                        ['key'=>'str','label'=>'STR'],
                        ['key'=>'dex','label'=>'DEX'],
                        ['key'=>'con','label'=>'CON'],
                        ['key'=>'int','label'=>'INT'],
                        ['key'=>'wis','label'=>'WIS'],
                        ['key'=>'cha','label'=>'CHA'],
                    ] as $ability)
                    <div class="text-center">
                        <label class="block text-gold-400 text-xs font-cinzel font-bold mb-2">{{ $ability['label'] }}</label>
                        <input type="number" name="{{ $ability['key'] }}" x-model="{{ $ability['key'] }}" min="1" max="30"
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-3 py-3 text-stone-100 text-center text-lg font-cinzel font-bold outline-none">
                        <div class="text-stone-500 text-xs mt-1 font-cinzel"
                             x-text="(Math.floor(({{ $ability['key'] }} - 10) / 2) >= 0 ? '+' : '') + Math.floor(({{ $ability['key'] }} - 10) / 2)">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Campaign --}}
            @if($campaigns->count())
            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN</label>
                <select name="campaign_id" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    <option value="">— None —</option>
                    @foreach($campaigns as $c)
                    <option value="{{ $c->id }}" {{ old('campaign_id', $character->campaign_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Notes --}}
            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NOTES</label>
                <textarea name="notes" rows="4"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base"
                          placeholder="Character backstory, traits, bonds...">{{ old('notes', $character->notes ?? '') }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
                    {{ isset($character) ? '✦ SAVE CHANGES' : '✦ CREATE CHARACTER' }}
                </button>
                <a href="{{ isset($character) ? route('characters.show', $character) : route('characters.index') }}"
                   class="px-6 py-3 border border-stone-700 hover:border-stone-500 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                    CANCEL
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
