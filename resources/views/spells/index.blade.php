@extends('layouts.app')
@section('title', 'Spells')
@section('page-title', 'Spell Compendium')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Search --}}
    <form method="GET" action="{{ route('spells.index') }}" class="mb-8 flex gap-3">
        <input type="text" name="search" value="{{ $search }}"
               class="flex-1 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none transition-all"
               placeholder="Search spells...">
        <button type="submit"
                class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            SEARCH
        </button>
        @if($search)
        <a href="{{ route('spells.index') }}" class="px-4 py-3 border border-stone-700 text-stone-400 hover:text-stone-200 font-cinzel text-sm rounded-xl transition-all">CLEAR</a>
        @endif
    </form>

    <div class="mb-4 text-stone-500 text-sm font-cinzel tracking-widest">{{ count($spells) }} SPELLS FOUND</div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @foreach($spells as $spell)
        <a href="{{ route('spells.show', $spell['index']) }}" class="card-hover bg-stone-900 rounded-xl p-4">
            <div class="text-2xl mb-2">✨</div>
            <div class="font-cinzel text-stone-200 text-sm font-semibold leading-tight">{{ $spell['name'] }}</div>
        </a>
        @endforeach
    </div>

    @if(empty($spells))
    <div class="text-center py-20">
        <div class="text-4xl mb-3 opacity-30">✨</div>
        <p class="text-stone-500 font-crimson italic">No spells found.</p>
    </div>
    @endif

</div>
@endsection
