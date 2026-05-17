@extends('layouts.app')
@section('title', 'Classes')
@section('page-title', 'Class Compendium')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6 text-stone-500 text-sm font-cinzel tracking-widest">{{ count($classes) }} CLASSES</div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @php
        $classIcons = [
            'barbarian'=>'🪓','bard'=>'🎵','cleric'=>'⛪','druid'=>'🌿',
            'fighter'=>'⚔️','monk'=>'🥋','paladin'=>'🛡️','ranger'=>'🏹',
            'rogue'=>'🗡️','sorcerer'=>'🔥','warlock'=>'👁️','wizard'=>'📚',
        ];
        @endphp

        @foreach($classes as $class)
        <a href="{{ route('classes.show', $class['index']) }}" class="card-hover bg-stone-900 rounded-xl p-6 text-center">
            <div class="text-4xl mb-3">{{ $classIcons[$class['index']] ?? '⚡' }}</div>
            <div class="font-cinzel text-stone-100 font-bold text-lg">{{ $class['name'] }}</div>
            <div class="text-stone-600 text-xs font-cinzel tracking-widest mt-1">D&D 5E CLASS</div>
        </a>
        @endforeach
    </div>

</div>
@endsection
