@extends('layouts.app')
@section('title', 'Characters')
@section('page-title', 'Characters')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100">Your Characters</h2>
            <p class="text-stone-500 font-crimson italic mt-1">{{ $characters->total() }} adventurers</p>
        </div>
        <a href="{{ route('characters.create') }}"
           class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
            ✦ NEW CHARACTER
        </a>
    </div>

    @if($characters->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($characters as $character)
        <div class="card-hover bg-stone-900 rounded-xl overflow-hidden">

            {{-- Character header --}}
            <div class="p-5 bg-gradient-to-r from-stone-900 to-stone-800 border-b border-stone-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-cinzel text-stone-100 font-bold text-lg">{{ $character->name }}</h3>
                        <p class="text-gold-400/70 text-sm font-cinzel tracking-wider mt-0.5">
                            Lv.{{ $character->level }} {{ $character->race }} {{ $character->class }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-stone-700 flex items-center justify-center text-2xl">
                        @php
                        $icons = ['Fighter'=>'⚔️','Wizard'=>'📚','Rogue'=>'🗡️','Cleric'=>'⛪','Paladin'=>'🛡️','Ranger'=>'🏹','Barbarian'=>'🪓','Bard'=>'🎵','Druid'=>'🌿','Monk'=>'🥋','Sorcerer'=>'🔥','Warlock'=>'👁️'];
                        echo $icons[$character->class] ?? '⚡';
                        @endphp
                    </div>
                </div>
            </div>

            {{-- HP bar --}}
            <div class="px-5 pt-4">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-xs font-cinzel text-stone-500 tracking-widest">HIT POINTS</span>
                    <span class="text-xs font-cinzel text-stone-400">{{ $character->current_hp }} / {{ $character->max_hp }}</span>
                </div>
                <div class="w-full bg-stone-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500
                        @if($character->hp_percentage > 60) bg-green-500
                        @elseif($character->hp_percentage > 30) bg-yellow-500
                        @else bg-red-500 @endif"
                        style="width: {{ $character->hp_percentage }}%">
                    </div>
                </div>
            </div>

            {{-- AC + Background --}}
            <div class="px-5 py-4 flex items-center gap-4 text-sm">
                <div class="flex items-center gap-1.5">
                    <span class="text-stone-500 text-xs font-cinzel">AC</span>
                    <span class="text-gold-400 font-cinzel font-bold">{{ $character->armor_class }}</span>
                </div>
                @if($character->background)
                <div class="text-stone-600 text-xs font-cinzel tracking-wider">• {{ $character->background }}</div>
                @endif
                @if($character->campaign)
                <div class="ml-auto text-gold-400/50 text-xs font-cinzel">📜 {{ Str::limit($character->campaign->title, 15) }}</div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="px-5 pb-5 flex gap-2">
                <a href="{{ route('characters.show', $character) }}"
                   class="flex-1 text-center text-xs py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel tracking-wider rounded-lg transition-all">
                    VIEW
                </a>
                <a href="{{ route('characters.edit', $character) }}"
                   class="flex-1 text-center text-xs py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel tracking-wider rounded-lg transition-all">
                    EDIT
                </a>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $characters->links() }}</div>

    @else
    <div class="text-center py-20 deco-border bg-stone-900/40 rounded-xl">
        <div class="text-6xl mb-4 opacity-20">⚔️</div>
        <h3 class="font-cinzel text-xl text-stone-400 mb-2">No characters yet</h3>
        <p class="text-stone-600 font-crimson italic mb-6">Roll your first adventurer and begin the journey.</p>
        <a href="{{ route('characters.create') }}"
           class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
            CREATE CHARACTER
        </a>
    </div>
    @endif

</div>
@endsection
