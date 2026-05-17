@extends('layouts.app')
@section('title', 'Monsters')
@section('page-title', 'Monster Compendium')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Search --}}
    <form method="GET" action="{{ route('monsters.index') }}" class="mb-8 flex gap-3">
        <input type="text" name="search" value="{{ $search }}"
               class="flex-1 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none transition-all"
               placeholder="Search monsters...">
        <button type="submit"
                class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            SEARCH
        </button>
        @if($search)
        <a href="{{ route('monsters.index') }}" class="px-4 py-3 border border-stone-700 text-stone-400 hover:text-stone-200 font-cinzel text-sm rounded-xl transition-all">
            CLEAR
        </a>
        @endif
    </form>

    <div class="mb-4 text-stone-500 text-sm font-cinzel tracking-widest">
        {{ count($monsters) }} MONSTERS FOUND
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @foreach($monsters as $monster)
        <a href="{{ route('monsters.show', $monster['index']) }}" class="card-hover bg-stone-900 rounded-xl p-4 text-center">
            <div class="text-3xl mb-2">
                @php
                    $types = ['beast'=>'🐺','dragon'=>'🐉','undead'=>'💀','humanoid'=>'👤','fiend'=>'😈','celestial'=>'👼','elemental'=>'🌊','construct'=>'🤖','giant'=>'👹','fey'=>'🧚'];
                    $name = strtolower($monster['name']);
                    $icon = '👾';
                    foreach($types as $k => $v) { if(str_contains($name, $k)) { $icon = $v; break; } }
                    echo $icon;
                @endphp
            </div>
            <div class="font-cinzel text-stone-200 text-sm font-semibold leading-tight">{{ $monster['name'] }}</div>
        </a>
        @endforeach
    </div>

    @if(empty($monsters))
    <div class="text-center py-20">
        <div class="text-4xl mb-3 opacity-30">🐉</div>
        <p class="text-stone-500 font-crimson italic">No monsters found. Try a different search.</p>
    </div>
    @endif

</div>
@endsection
