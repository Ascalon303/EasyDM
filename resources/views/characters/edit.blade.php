@extends('layouts.app')
@section('title', 'Edit ' . $character->name)
@section('page-title', 'Edit Character')
@section('breadcrumb', 'Characters / ' . $character->name)

@section('content')
<div class="max-w-3xl mx-auto" x-data="{ str: {{ $character->ability_scores['str'] ?? 10 }}, dex: {{ $character->ability_scores['dex'] ?? 10 }}, con: {{ $character->ability_scores['con'] ?? 10 }}, int: {{ $character->ability_scores['int'] ?? 10 }}, wis: {{ $character->ability_scores['wis'] ?? 10 }}, cha: {{ $character->ability_scores['cha'] ?? 10 }} }">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ EDIT CHARACTER</h2>

        <form method="POST" action="{{ route('characters.update', $character) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CHARACTER NAME *</label>
                    <input type="text" name="name" value="{{ old('name', $character->name) }}" required
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">RACE *</label>
                    <select name="race" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        @foreach(['Human','Elf','Dwarf','Halfling','Gnome','Half-Elf','Half-Orc','Tiefling','Dragonborn','Aasimar','Tabaxi'] as $race)
                        <option {{ old('race',$character->race)===$race?'selected':'' }}>{{ $race }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CLASS *</label>
                    <select name="class" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        @foreach(['Barbarian','Bard','Cleric','Druid','Fighter','Monk','Paladin','Ranger','Rogue','Sorcerer','Warlock','Wizard'] as $cls)
                        <option {{ old('class',$character->class)===$cls?'selected':'' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">LEVEL</label>
                    <input type="number" name="level" value="{{ old('level',$character->level) }}" min="1" max="20"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">BACKGROUND</label>
                    <input type="text" name="background" value="{{ old('background',$character->background) }}"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
            </div>

            <div>
                <div class="rune-divider mb-4">✦ COMBAT STATS ✦</div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">MAX HP</label>
                        <input type="number" name="max_hp" value="{{ old('max_hp',$character->max_hp) }}" min="1"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CURRENT HP</label>
                        <input type="number" name="current_hp" value="{{ old('current_hp',$character->current_hp) }}" min="0"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">ARMOR CLASS</label>
                        <input type="number" name="armor_class" value="{{ old('armor_class',$character->armor_class) }}" min="1"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                </div>
            </div>

            <div>
                <div class="rune-divider mb-4">✦ ABILITY SCORES ✦</div>
                <div class="grid grid-cols-6 gap-3">
                    @foreach([['key'=>'str','label'=>'STR'],['key'=>'dex','label'=>'DEX'],['key'=>'con','label'=>'CON'],['key'=>'int','label'=>'INT'],['key'=>'wis','label'=>'WIS'],['key'=>'cha','label'=>'CHA']] as $a)
                    <div class="text-center">
                        <label class="block text-gold-400 text-xs font-cinzel font-bold mb-2">{{ $a['label'] }}</label>
                        <input type="number" name="{{ $a['key'] }}" x-model="{{ $a['key'] }}" min="1" max="30"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-2 py-3 text-stone-100 text-center text-lg font-cinzel font-bold outline-none">
                        <div class="text-stone-500 text-xs mt-1 font-cinzel"
                             x-text="(Math.floor(({{ $a['key'] }} - 10) / 2) >= 0 ? '+' : '') + Math.floor(({{ $a['key'] }} - 10) / 2)">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($campaigns->count())
            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN</label>
                <select name="campaign_id" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    <option value="">— None —</option>
                    @foreach($campaigns as $c)
                    <option value="{{ $c->id }}" {{ $character->campaign_id==$c->id?'selected':'' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NOTES</label>
                <textarea name="notes" rows="3"
                          class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base">{{ old('notes',$character->notes) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                    ✦ SAVE CHANGES
                </button>
                <a href="{{ route('characters.show', $character) }}"
                   class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all hover:border-stone-500">
                    CANCEL
                </a>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-stone-800">
            <form method="POST" action="{{ route('characters.destroy', $character) }}"
                  onsubmit="return confirm('Delete {{ $character->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-crimson-500 hover:text-crimson-400 text-xs font-cinzel tracking-widest transition-colors">
                    ✕ DELETE CHARACTER
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
